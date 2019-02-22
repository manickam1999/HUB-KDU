package com.example.user.fyp;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;

import static android.content.Context.MODE_PRIVATE;

//This background task is called in certain times to check whether new invoices has been uploaded to the server
public class InvoiceCheckBackground extends AsyncTask<String,Void,String> {
    Context context;
    String username;
    InvoiceCheckBackground (Context ctx) {
        context = ctx;
    }
    @Override
    protected String doInBackground(String... params) {
        String check_url = "http://student.kdupg.edu.my/saints/CheckSem.php";
        try {
            username = params[0];
            URL url = new URL(check_url);
            HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
            httpURLConnection.setRequestMethod("POST");
            httpURLConnection.setDoOutput(true);
            httpURLConnection.setDoInput(true);
            OutputStream outputStream = httpURLConnection.getOutputStream();
            BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
            String post_data = URLEncoder.encode("StudentId","UTF-8")+"="+URLEncoder.encode(username,"UTF-8");
            bufferedWriter.write(post_data);
            bufferedWriter.flush();
            bufferedWriter.close();
            outputStream.close();
            InputStream inputStream = httpURLConnection.getInputStream();
            BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream,"iso-8859-1"));
            String result="";
            String line="";
            while((line = bufferedReader.readLine())!= null) {
                result += line;
            }
            bufferedReader.close();
            inputStream.close();
            httpURLConnection.disconnect();
            return result;
        } catch (MalformedURLException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return null;
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
    }

    @Override
    protected void onPostExecute(String result) {
        int amnt = Integer.parseInt(result);
        SharedPreferences sp = context.getSharedPreferences("data",MODE_PRIVATE);
        SharedPreferences.Editor edit = sp.edit();

        if(amnt > sp.getInt("semNo",1)) //checks the servers invoice count and compares it to the count in the app
        {
            edit.putInt("semNo",amnt); //if more then that means a new invoice has been uploaded
            edit.apply();
            NewInvoiceNotification noti = new NewInvoiceNotification(context);
            noti.sendNoti(username);
        }
    }

    @Override
    protected void onProgressUpdate(Void... values) {
        super.onProgressUpdate(values);
    }
}