package com.example.user.fyp;

import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Environment;
import android.widget.Toast;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
public class LoadPDFBackground extends AsyncTask<String, Void, String> {
    Context context;
    String filePath;
    String fileName;
    String type;
    LoadPDFBackground(Context context) {this.context = context;}

    //Background task to generate a pdf with the pdf generating script hosted on the server
    @Override
    protected String doInBackground(String... params) {
        String id = params[0];
        String sem = params[1];
        type = params[2];
        if(type.equals("0"))
        {
             filePath = Environment
                .getExternalStorageDirectory().getAbsolutePath()
                + "/KDU/Temp";
             fileName = "invoice.pdf";
        }
        else
        {
            filePath = Environment
                    .getExternalStorageDirectory().getAbsolutePath()
                    + "/KDU/Invoices";
            fileName = "Invoice_"+id+"_Sem"+sem+".pdf";
        }
        String urlString = "http://student.kdupg.edu.my/saints/invoice-db.php?studentId="+id+"&semNo="+sem+"&phpType=download";
        HttpURLConnection c;
        try {
            URL url = new URL(urlString);
            c = (HttpURLConnection) url.openConnection();
            c.setRequestMethod("GET");
            c.setDoOutput(true);
            c.connect();
        } catch (IOException e1) {
            return e1.getMessage();
        }

        File myFilesDir = new File(filePath);

        File file= new File(myFilesDir, fileName);

        if (file.exists())
        {
            file.delete();
        }

        if ((myFilesDir.mkdirs() || myFilesDir.isDirectory())) {
            try {
                InputStream is = c.getInputStream();
                FileOutputStream fos = new FileOutputStream(myFilesDir
                        + "/" + fileName);

                byte[] buffer = new byte[1024];
                int len1 = 0;
                while ((len1 = is.read(buffer)) != -1) {
                    fos.write(buffer, 0, len1);
                }
                fos.close();
                is.close();
                return "1" ;
            }
            catch (Exception e) {
                return e.getMessage();
            }
        }
        else
        {
            return "Unable to create/read folder, Please check the FAQ for further information";
        }
    }

    @Override
    protected void onPostExecute(String result) {
        super.onPostExecute(result);
        if(result.equals("1")) {
            if(type.equals("0"))
            {
                Intent intent = new Intent(context, PDFViewActivity.class);
                context.startActivity(intent);
            }
            else
            {
                Toast.makeText(context,"Invoice has been downloaded at" + filePath,Toast.LENGTH_LONG).show();
            }
        }
        else
            Toast.makeText(context, result, Toast.LENGTH_LONG).show();
    }
}
