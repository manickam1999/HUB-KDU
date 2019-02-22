package com.example.user.fyp;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;

public class LoadingActivity extends AppCompatActivity
{
    //A buffer splash screen while user's invoices are loaded
        protected void onCreate(Bundle savedInstanceState) {
            super.onCreate(savedInstanceState);
            setContentView(R.layout.layout_loading);
            Intent intent = getIntent();
            String username = intent.getStringExtra("id");
            if(username == null)
            {
                SharedPreferences sp = this.getSharedPreferences("data",MODE_PRIVATE);
                username = sp.getString("id",null);
            }
            ImageView load = (ImageView) findViewById(R.id.loadingBlack);
            Animation anim = AnimationUtils.loadAnimation(this,R.anim.rotate);
            load.startAnimation(anim);
            LoadInvoiceBackground loading = new LoadInvoiceBackground(this);
            loading.execute(username);
        }
}
