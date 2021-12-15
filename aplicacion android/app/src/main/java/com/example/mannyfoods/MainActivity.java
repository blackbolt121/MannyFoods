package com.example.mannyfoods;

import androidx.appcompat.app.AppCompatActivity;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {
    private int flag;
    private Login log;
    private Signin signin;
    private dashboard dash;
    private compras comp;
    private boolean succesOnLogin;
    private SharedPreferences pref;
    private SharedPreferences.Editor editor;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        initActivity();
        succesOnLogin = hasSession();
        super.onCreate(savedInstanceState);
        if(succesOnLogin){
            succesOnLogin = true;
            setFlag(2);
        }else{
            setFlag(0);
        }
    }

    @Override
    protected void onResume() {
        super.onResume();
        printMessage("On resume");
        if(hasSession()){
            succesOnLogin = true;
            setFlag(2);
        }else{
            succesOnLogin = false;
            setFlag(0);
        }
    }

    public void setFlag(int value){
        int lastValue = flag;
        this.flag = value;
        if(!setLayout()) {
            flag = lastValue;
        }
    }
    private boolean setLayout(){
        switch (flag){
            case 0:
                setContentView(R.layout.activity_main);
                log = new Login(this);
                return true;
            case 1:
                setContentView(R.layout.register);
                signin = new Signin(this);
                return true;
            case 2:
                if(succesOnLogin){
                    setContentView(R.layout.activity_main2);
                    dash = new dashboard(this,this.getSessionAttribute("email"),this.getSessionAttribute("uuid"));
                }
                return succesOnLogin;
            case 3:
                if(dash.getSelectedProduct() != null){
                    setContentView(R.layout.editproduct);
                    editInventory e = new editInventory(this,dash.getSelectedProduct());
                    return true;
                }
                return false;
            case 4:
                    setContentView(R.layout.activity_main3);
                    comp = new compras(this, this.getSessionAttribute("email"));
                return true;
            case 5:
                    setContentView(R.layout.product_compras);
                    if(comp.getSelectedProduct() != null){
                        addCompra add = new addCompra(this,comp.getSelectedProduct());
                        return true;
                    }
                return false;
            case 6:
                    setContentView(R.layout.anadir_compras);
                    añadirProducto a = new añadirProducto(this);
            default: return false;
        }
    }

    public void setSuccesOnLogin(boolean succesOnLogin) {
        this.succesOnLogin = succesOnLogin;
    }
    private void initActivity(){
        pref = getSharedPreferences("user",MODE_PRIVATE);
    }
    private void editPreferences(){
        editor = pref.edit();
    }
    public void setSessionAttribute(String key, String value){
        editPreferences();
        editor.putString(key,value);
        editor.commit();
    }
    public String getSessionAttribute(String key){
        return pref.getString(key,"").toString();
    }
    public boolean hasSession(){
        return (!getSessionAttribute("uuid").equals(""))? true : false;
    }
    public void logout(){
        if(hasSession()){
            editPreferences();
            setSessionAttribute("uuid","");
            setSessionAttribute("email","");
            setSessionAttribute("name","");
            setSessionAttribute("day","");
            setSessionAttribute("month","");
            setSessionAttribute("year","");
            setFlag(0);
        }
    }
    public void printMessage(String s){
        Toast.makeText(this,s,Toast.LENGTH_SHORT).show();
    }
}