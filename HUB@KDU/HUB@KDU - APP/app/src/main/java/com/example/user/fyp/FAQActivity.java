package com.example.user.fyp;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.NavigationView;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.view.MenuItem;
import android.view.View;
import android.widget.Toast;

import com.github.barteksc.pdfviewer.PDFView;

import static android.content.Intent.FLAG_ACTIVITY_CLEAR_TASK;
import static android.content.Intent.FLAG_ACTIVITY_NEW_TASK;

public class FAQActivity extends AppCompatActivity {
    private DrawerLayout dl;
    private ActionBarDrawerToggle t;
    private NavigationView nv;
    private SharedPreferences sp;
    private SharedPreferences.Editor edit;
    private Context context;
    //This activity helps users that meet an error that cannot be solved through the app and must go through settings
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_faq);
        sp = this.getSharedPreferences("data", MODE_PRIVATE);
        edit = sp.edit();
        context = this;
        PDFView view = findViewById(R.id.faqPdf);
        view.fromAsset("FAQ.pdf").load();
        nv = (NavigationView) findViewById(R.id.nv);
        nv.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                Intent intent;
                if(item.getItemId() == R.id.item_logout)
                {
                    edit.clear();
                    edit.apply();
                    intent = new Intent(context,LoginActivity.class);
                    intent.addFlags(FLAG_ACTIVITY_NEW_TASK | FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                }
                else if(item.getItemId() == R.id.item_invoice)
                {
                    intent = new Intent(context,LoadingActivity.class);
                    intent.addFlags(FLAG_ACTIVITY_NEW_TASK | FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                }
                else
                {
                    intent = new Intent(context,FAQActivity.class);
                    intent.addFlags(FLAG_ACTIVITY_NEW_TASK | FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                }
                return false;
            }
        });
    }
    public void triggerPermission(View v)
    {
        if(!PermissionCheck.checkRead(this))
        {
            PermissionCheck.selfPerm(this);
            Toast.makeText(this,"If a prompt does not appear, read the rest of the FAQ",Toast.LENGTH_LONG).show();
        }
        else
        {
            Toast.makeText(this,"Permission already granted",Toast.LENGTH_LONG).show();
        }
    }

    public void onBackPressed()
    {

    }
}

