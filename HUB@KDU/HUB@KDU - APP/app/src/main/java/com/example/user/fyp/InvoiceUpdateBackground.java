package com.example.user.fyp;

import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AlertDialog;
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

public class InvoiceUpdateBackground extends AsyncTask<String,Void,String> {
    //This background task is used to update a semester once it is successfully paid off
    Context context;
    String username;
    String sem;
    InvoiceUpdateBackground (Context ctx) {
        context = ctx;
    }
    @Override
    protected String doInBackground(String... params) {
        String check_url = "http://student.kdupg.edu.my/saints/UpdateSem.php";
        try {
            username = params[0];
            sem = params[1];
            URL url = new URL(check_url);
            HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
            httpURLConnection.setRequestMethod("POST");
            httpURLConnection.setDoOutput(true);
            httpURLConnection.setDoInput(true);
            OutputStream outputStream = httpURLConnection.getOutputStream();
            BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
            String post_data = URLEncoder.encode("StudentId","UTF-8")+"="+URLEncoder.encode(username,"UTF-8") + "&" +
                                 URLEncoder.encode("SemNo","UTF-8")+"="+URLEncoder.encode(sem,"UTF-8");
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
        if(amnt > 0)
        {
            Toast.makeText(context,"Payment Successful",Toast.LENGTH_LONG).show();
            LoadInvoiceBackground load = new LoadInvoiceBackground(context);
            load.execute(username);
        }
        else
        {
            Toast.makeText(context,"Payment Failed",Toast.LENGTH_LONG).show();
            LoadInvoiceBackground load = new LoadInvoiceBackground(context);
            load.execute(username);
        }
    }

    @Override
    protected void onProgressUpdate(Void... values) {
        super.onProgressUpdate(values);
    }
}