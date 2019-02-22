package com.example.user.fyp;

import java.util.ArrayList;
//Invoice object that holds all the data required to make an invoice
public class Invoice
{
    public static ArrayList<Invoice> invoiceArray;
    public String name;
    public String id;
    public String semStartDate;
    public String semEndDate;
    public int semNo;
    public String payStartDate;
    public String payEndDate;
    public String payStatus;
    public String course;
    public ArrayList<Subject> subs;
    public Invoice()
    {

    }
    public Invoice(String name, String id, String semStartDate, String semEndDate, String payStartDate, String payEndDate, String payStatus, String course, int semNo, ArrayList<Subject> subs)
    {
        this.name = name;
        this.id = id;
        this.semStartDate = semStartDate;
        this.semEndDate = semEndDate;
        this.payStartDate = payStartDate;
        this.payEndDate = payEndDate;
        this.payStatus = payStatus;
        this.course = course;
        this.subs = subs;
        this.semNo = semNo;
    }

}
