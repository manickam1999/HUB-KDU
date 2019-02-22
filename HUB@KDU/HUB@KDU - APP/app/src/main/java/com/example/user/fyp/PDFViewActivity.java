package com.example.user.fyp;

import android.content.Intent;
import android.os.Bundle;
import android.os.Environment;
import android.support.v7.app.AppCompatActivity;
import android.webkit.WebView;
import android.widget.Toast;

import com.github.barteksc.pdfviewer.PDFView;

import java.io.File;
//This activity is used to view the invoice chosen by students
public class PDFViewActivity extends AppCompatActivity{
    private WebView pdfViewer;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_pdfview);
        Intent intent = getIntent();
            File filePath = new File(Environment
                    .getExternalStorageDirectory().getAbsolutePath()
                    + "/KDU/Temp");
            File file = new File(filePath,"invoice.pdf");
            PDFView pdfView = findViewById(R.id.pdfView);
            pdfView.fromFile(file).load();
    }


    public void onBackPressed()
    {
        finish();
    }


}
