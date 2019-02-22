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
import android.widget.TextView;

import static android.content.Intent.FLAG_ACTIVITY_CLEAR_TASK;
import static android.content.Intent.FLAG_ACTIVITY_NEW_TASK;

public class PaymentActivity extends AppCompatActivity {

    //Buffer page for users to select what payment choice they wish to use
    private Button btn_pay1;
    private Button btn_pay2;
    private DrawerLayout dl;
    private ActionBarDrawerToggle t;
    private NavigationView nv;
    private String id;
    private String sem;
    private SharedPreferences sp;
    private SharedPreferences.Editor edit;
    private Context context;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_payment);
        context = this;
        sp = this.getSharedPreferences("data", MODE_PRIVATE);
        edit = sp.edit();
        btn_pay1 = findViewById(R.id.btn_pay1);
        btn_pay2 = findViewById(R.id.btn_pay2);
        Intent intent = getIntent();
        int price = intent.getIntExtra("price",0);
        id = intent.getStringExtra("id");
        sem = intent.getStringExtra("sem");
        TextView details = findViewById(R.id.tv_paydetails);
        details.setText("ID : " + id + "\nSem : " + sem + "\nTotal : RM" + price);


        btn_pay1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                paymentChoice(0);
            }
        });

        btn_pay2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                paymentChoice(1);
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

    public void paymentChoice(int choice) {
        if (choice == 1) {
            Intent intent = new Intent(this, BankingActivity.class);
            intent.putExtra("id",id);
            intent.putExtra("sem",sem);
            startActivity(intent);
        } else {
            Intent intent = new Intent(this, CardActivity.class);
            intent.putExtra("id",id);
            intent.putExtra("sem",sem);
            startActivity(intent);
        }
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        if(t.onOptionsItemSelected(item))
            return true;

        return super.onOptionsItemSelected(item);
    }
}
