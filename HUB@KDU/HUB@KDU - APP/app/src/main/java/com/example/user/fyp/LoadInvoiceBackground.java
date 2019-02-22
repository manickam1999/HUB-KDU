package com.example.user.fyp;


import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.widget.Toast;

import com.google.gson.Gson;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

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
import java.util.ArrayList;

import static android.content.Context.MODE_PRIVATE;
//Background task to pull the user's invoice data through a server script
public class LoadInvoiceBackground extends AsyncTask<String,Void,String> {
    Context context;
    int semTotalNo;
    String id;

    public LoadInvoiceBackground(Context context) {
        this.context = context;
    }
    @Override
    protected String doInBackground(String... params) {
        String invoice_url = "http://student.kdupg.edu.my/saints/GetInvoice.php";
            try {
                id = params[0];
                URL url = new URL(invoice_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("StudentId","UTF-8")+"="+URLEncoder.encode(id,"UTF-8");
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
    protected void onPostExecute(String result)
    {
        Invoice.invoiceArray = new ArrayList<>();
        if(result.length() == 5)
        {
            Intent intent = new Intent(context,InvoiceListActivity.class);
            intent.putExtra("empty","empty");
            intent.putExtra("id",id);
            context.startActivity(intent);
            return;
        }
        try {
            JSONArray invoiceArr = new JSONArray(result);
            semTotalNo = invoiceArr.length();
            SharedPreferences sp = context.getSharedPreferences("data",MODE_PRIVATE);
            SharedPreferences.Editor edit = sp.edit();
            edit.putInt("semNo",invoiceArr.length());
            edit.apply();
            for(int i = 0; i < semTotalNo; i++)
            {
                JSONObject invoice = invoiceArr.getJSONObject(i);
                String name,id,payStatus,course;
                String semStart,semEnd,payStart,payEnd;
                int semNo;
                ArrayList<Subject> subs = new ArrayList<>();
                name = invoice.getString("Name");
                id = invoice.getString("ID");
                semStart = invoice.getString("SemStart");
                semEnd = invoice.getString("SemEnd");
                semNo = Integer.parseInt(invoice.getString("SemNo"));
                payStart = invoice.getString("PayStart");
                payEnd = invoice.getString("PayEnd");
                course = invoice.getString("CourseName");
                payStatus = invoice.getString("PayStatus");
                JSONArray invSubs = invoice.getJSONArray("AllSubData");
                int subsNo = invSubs.length();
                for(int x = 0; x < subsNo; x++)
                {
                    String subCode, subName;
                    int subPrice;
                    JSONObject sub = invSubs.getJSONObject(x);
                    subCode = sub.getString("SubCode");
                    subName = sub.getString("SubName");
                    subPrice = Integer.parseInt(sub.getString("SubPrice"));
                    Subject subObj = new Subject(subCode,subName,subPrice);
                    subs.add(subObj);
                }
                Invoice.invoiceArray.
                        add(new Invoice(name,id,semStart,semEnd,payStart,payEnd,payStatus,course,semNo,subs));
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }

        Intent intent = new Intent(context,InvoiceListActivity.class);
        intent.putExtra("empty","nEmpty");
        intent.putExtra("id",this.id);
        context.startActivity(intent);
        ((Activity)context).finish();
    }

    @Override
    protected void onProgressUpdate(Void... values) {
        super.onProgressUpdate(values);
    }
}
