package com.example.user.fyp;

import android.Manifest;
import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.pm.PackageManager;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AlertDialog;
import android.widget.Toast;

//This class helps check for permissions as viewing and downloading pdf requires storage permissions
public class PermissionCheck{
    public static void readAndWriteExternalStorage(Context context){
        final Context ctx = context;
        if(!checkRead(context)) {
            AlertDialog.Builder builder = new AlertDialog.Builder(context);
            builder.setTitle("Permissions Are Needed")
                    .setMessage("This app requires storage permissions for some of its functions to work properly. Please allow when prompted")
                    .setCancelable(false)
                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            selfPerm(ctx);
                        }
                    });
            AlertDialog alert = builder.create();
            alert.show();
            return;
        }
    }
    public static boolean checkRead(Context context)
    {
        if(ActivityCompat.checkSelfPermission(context, Manifest.permission.READ_EXTERNAL_STORAGE) != PackageManager.PERMISSION_GRANTED
                && ActivityCompat.checkSelfPermission(context, Manifest.permission.WRITE_EXTERNAL_STORAGE) != PackageManager.PERMISSION_GRANTED)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public static void selfPerm(Context context)
    {
        ActivityCompat.requestPermissions((Activity) context,
                new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE,
                        Manifest.permission.READ_EXTERNAL_STORAGE}, 1);
    }
}