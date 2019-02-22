package com.example.user.fyp;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Build;
import android.support.annotation.NonNull;
import android.support.annotation.RequiresApi;
import android.support.design.widget.NavigationView;
import android.support.v4.widget.DrawerLayout;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.ListView;
import android.widget.Toast;

import com.google.gson.Gson;

import java.util.ArrayList;

import static android.content.Intent.FLAG_ACTIVITY_CLEAR_TASK;
import static android.content.Intent.FLAG_ACTIVITY_NEW_TASK;

public class InvoiceListActivity extends AppCompatActivity {

    private DrawerLayout dl;
    private ActionBarDrawerToggle t;
    private NavigationView nv;
    private ListView list;
    private SwipeRefreshLayout pullToRefresh;
    private String id;
    private SharedPreferences sp;
    private SharedPreferences.Editor edit;
    private Context context;
    //This activity is where all the invoices are loaded out through the Custom adapter and is where most of
    //Users will be on

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_list);
        context = this;
        Intent intent = getIntent();
        String isEmpty = intent.getStringExtra("empty");
        id = intent.getStringExtra("id");
        sp = this.getSharedPreferences("data",MODE_PRIVATE);
        edit = sp.edit();
        edit.putString("id",id);
        edit.apply();
        if(!PermissionCheck.checkRead(this))
        {
            PermissionCheck.readAndWriteExternalStorage(context);
        }
        ReceivedAlarm alarm = new ReceivedAlarm();
        alarm.setAlarm(this);

        if(isEmpty != null)
        {
            if(isEmpty.equals("empty")) {
                AlertDialog.Builder builder;
                builder = new AlertDialog.Builder(this);
                builder.setTitle("No Invoices Found")
                        .setMessage("If you think this is an error please check your internet connection or look for your department admins")
                        .show();
            }
            else
            {
                CustomListAdapter adapter=new CustomListAdapter(Invoice.invoiceArray,this);
                list=(ListView)findViewById(R.id.list);
                list.setAdapter(adapter);

                pullToRefresh = findViewById(R.id.swiperefresh);
                pullToRefresh.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
                @Override
                public void onRefresh() {
                    refreshInvoices();
                }
            });
            }
        }

        nv = (NavigationView) findViewById(R.id.nv);
        nv.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                Intent intent;
                if(item.getItemId() == R.id.item_logout)
                {
                    ReceivedAlarm menuAlarm = new ReceivedAlarm();
                    menuAlarm.cancelAlarm(context);
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
    @Override
    public void onResume() {
        super.onResume();
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        if(t.onOptionsItemSelected(item))
            return true;

        return super.onOptionsItemSelected(item);
    }
    @Override
    public void onBackPressed() {

    }

    public void refreshInvoices()
    {
        LoadInvoiceBackground reload = new LoadInvoiceBackground(InvoiceListActivity.this); // your code
        reload.execute(id);
        pullToRefresh.setRefreshing(true);
        finish();
    }

    @Override
    public void onPause()
    {
        super.onPause();
    }




}