package com.example.user.fyp;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.annotation.NonNull;
import android.support.design.widget.NavigationView;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;

import static android.content.Intent.FLAG_ACTIVITY_CLEAR_TASK;
import static android.content.Intent.FLAG_ACTIVITY_NEW_TASK;

public class BankingActivity extends AppCompatActivity {
    private DrawerLayout dl;
    private ActionBarDrawerToggle t;
    private NavigationView nv;
    private SharedPreferences sp;
    private SharedPreferences.Editor edit;
    private Context context;
    // Activity that should be handling payments through online banking
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_banking);
        context = this;
        sp = this.getSharedPreferences("data", MODE_PRIVATE);
        edit = sp.edit();
        Intent intent = getIntent();
        final String id = intent.getStringExtra("id");
        final String sem = intent.getStringExtra("sem");
        Button pay = findViewById(R.id.btn_pay2);
        pay.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                InvoiceUpdateBackground update = new InvoiceUpdateBackground(BankingActivity.this);
                update.execute(id,sem);
            }
        });


        nv = (NavigationView) findViewById(R.id.nv);
        nv.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                Intent intent;
                if(item.getItemId() == R.id.item_logout)
                {
                    edit.clear();
                    edit.commit();
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
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        if(t.onOptionsItemSelected(item))
            return true;

        return super.onOptionsItemSelected(item);
    }
}
