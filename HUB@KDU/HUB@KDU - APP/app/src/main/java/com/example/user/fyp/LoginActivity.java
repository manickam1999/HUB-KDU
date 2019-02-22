package com.example.user.fyp;

import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class LoginActivity extends AppCompatActivity {
    //Login Activity that will be seen at the beginning to check Student's id and password inputs
    private Button btn_login;
    private TextView username;
    private TextView password;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_login);
        SharedPreferences sp = this.getSharedPreferences("data",MODE_PRIVATE);
        String id = sp.getString("id",null);
        if(id != null)
        {
            Intent intent = new Intent(this,LoadingActivity.class);
            intent.putExtra("id",id);
            startActivity(intent);
            finish();
        }
        else
        {
            ReceivedAlarm alarm = new ReceivedAlarm();
            alarm.cancelAlarm(this);
            AlertDialog alertDialog = new AlertDialog.Builder(this).create();
            alertDialog.setTitle("IMPORTANT NOTES");
            alertDialog.setMessage("This app does not support late payments, all late payments should be done at the Bursary");
            alertDialog.show();
        }
        username = findViewById(R.id.name_editText);
        password = findViewById(R.id.password_editText);
        btn_login = findViewById(R.id.login_button);
        btn_login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                loadInvoices(username.getText().toString(),password.getText().toString());
            }
        });
    }
    public void loadInvoices(String username,String password){
        String id = username.replace(" ","");
        String pw = password.replace(" ","");
        if(id.length() > 0 && pw.length() > 0)
        {
            LoginBackground login = new LoginBackground(this);
            login.execute(username,password);
        }
        else
        {
            Toast.makeText(this,"ID or Password is empty! Please try again",Toast.LENGTH_SHORT).show();
        }
    }

    public void onBackPressed(){
        finishAffinity();
    }



}
