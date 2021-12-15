package com.example.mannyfoods;

import android.app.Activity;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class Login {
    private TextView user, password;
    private Button login, signin, forgot;
    private MainActivity activity;
    public Login(MainActivity activity){
        this.activity = activity;
        this.user = (TextView)activity.findViewById(R.id.user);
        this.password = (TextView)activity.findViewById(R.id.password);
        this.login = (Button)activity.findViewById(R.id.login_button);
        this.signin = (Button)activity.findViewById(R.id.signin_button);
        this.forgot = (Button)activity.findViewById(R.id.forgot);
        this.login.setOnClickListener(x -> {
            this.login(x);
        });
        this.signin.setOnClickListener(x -> {
            activity.setFlag(1);
        });
        this.forgot.setOnClickListener(x -> {
            activity.setFlag(2);
        });
    }
    public void login(View v){
        String usr = user.getText().toString(), pass = password.getText().toString();
        if(usr.length() == 0 || pass.matches("\\s+")) {
            Toast.makeText(activity,"Favor de ingresar un usuario valido", Toast.LENGTH_SHORT).show();
        }else {
            if (pass.length() > 0 && !pass.matches("\\s+")) {
                //pass = MD5.build(pass);
                //Aqui se manda el metodo POST
                webservice web = new webservice(activity);
                web.login(usr,pass, this);
            } else {
                Toast.makeText(activity, "Favor de ingresar el password", Toast.LENGTH_SHORT).show();
            }
        }
    }
    public void setBlankPassword(){
        this.password.setText("");
    }

}
