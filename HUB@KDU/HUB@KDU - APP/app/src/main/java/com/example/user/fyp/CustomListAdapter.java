package com.example.user.fyp;

import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.Drawable;
import android.support.v7.widget.PopupMenu;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

public class CustomListAdapter extends ArrayAdapter<Invoice>
{
    private ArrayList<Invoice> invoiceList;
    private Context context;
    //An adapter that loads out a custom layout created for the invoices
    public CustomListAdapter(ArrayList<Invoice> invoiceList, Context context) {
        super(context, R.layout.layout_listrow, invoiceList);
        this.context = context;
        this.invoiceList = invoiceList;
    }

    public View getView(int position, View view, ViewGroup parent) {
        LayoutInflater inflater = LayoutInflater.from(context);
        View rowView=inflater.inflate(R.layout.layout_listrow, null,true);

        TextView semestertxt = (TextView) rowView.findViewById(R.id.semester);
        TextView duetxt = (TextView) rowView.findViewById(R.id.duedate);
        TextView amountxt = (TextView) rowView.findViewById(R.id.amount);
        ImageView more = rowView.findViewById(R.id.more);
        ImageView statusimg = (ImageView) rowView.findViewById(R.id.status);
        Drawable paidIcon = rowView.getResources().getDrawable(R.drawable.succes);
        Drawable pendingIcon = rowView.getResources().getDrawable(R.drawable.pending);
        Drawable lateIcon = rowView.getResources().getDrawable(R.drawable.late);
        TextView dateLabel = (TextView) rowView.findViewById(R.id.datelabel);
        int semNo = invoiceList.get(position).semNo;
        final String sem = String.valueOf(semNo);
        final String id = invoiceList.get(position).id;
        final String status = invoiceList.get(position).payStatus;
        dateLabel.setText("Due Date :");
        ArrayList<Subject> subs = invoiceList.get(position).subs;
        int subNo = subs.size();
        int total = 650;
        for(int i = 0; i < subNo; i++)
        {
            total += subs.get(i).subPrice;
        }
        final int price = total;
        amountxt.setText("RM"+total);
        semestertxt.setText("Semester : " + semNo);
        more.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v) {

                showMenu(v,sem,id,price,status);
            }
        });
        String payDate = invoiceList.get(position).payEndDate;
        Date date = null;
        try {
            date = new SimpleDateFormat("yyyy-MM-dd").parse(payDate);
            String formattedDate = new SimpleDateFormat("dd/MM/yyyy").format(date);
            duetxt.setText(formattedDate);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        if(status.equals("PENDING"))
            statusimg.setImageDrawable(pendingIcon);
        else if(status.equals("LATE"))
            statusimg.setImageDrawable(lateIcon);
        else if(status.equals("PAID"))
            statusimg.setImageDrawable(paidIcon);
        return rowView;
    }

    public void showMenu (View view,String sem,String id,int price,String status)
    {
        final String semNo = sem;
        final String idNo = id;
        final int priceNo = price;
        final String statusNo = status;


        PopupMenu menu = new PopupMenu (context, view);
        menu.setOnMenuItemClickListener (new PopupMenu.OnMenuItemClickListener ()
        {
            @Override
            public boolean onMenuItemClick (MenuItem item)
            {
                int itemId = item.getItemId();
                if(itemId == R.id.item_view)
                {
                    if(PermissionCheck.checkRead(context))
                    {
                        LoadPDFBackground download = new LoadPDFBackground(context);
                        download.execute(idNo,semNo,"0");
                    }
                    else
                    {
                        Toast.makeText(context,"Access denied, Please head to FAQ to fix this",Toast.LENGTH_LONG).show();
                    }
                }
                else if(itemId == R.id.item_download)
                {
                    if(PermissionCheck.checkRead(context))
                    {
                        LoadPDFBackground download = new LoadPDFBackground(context);
                        download.execute(idNo,semNo,"1");
                    }
                    else
                    {
                        Toast.makeText(context,"Access denied, Please head to FAQ to fix this",Toast.LENGTH_LONG).show();
                    }
                }
                else if(itemId == R.id.item_pay)
                {
                    if(statusNo.equals("PENDING"))
                    {
                        Intent intent = new Intent(context,PaymentActivity.class);
                        intent.putExtra("price",priceNo);
                        intent.putExtra("id",idNo);
                        intent.putExtra("sem",semNo);
                        context.startActivity(intent);
                    }
                    else if(statusNo.equals("PAID"))
                    {
                        Toast.makeText(context,"This semester has already been paid off",Toast.LENGTH_SHORT).show();
                    }
                    else
                    {
                        Toast.makeText(context,"The due date for this invoice has passed, Please proceed to bursary",Toast.LENGTH_LONG).show();
                    }
                }
                return true;
            }
        });
        menu.inflate(R.menu.menu_invoice);
        menu.show();
    }


}
