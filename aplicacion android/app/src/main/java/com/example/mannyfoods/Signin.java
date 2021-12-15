package com.example.mannyfoods;

import android.app.Activity;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.util.Date;

public class Signin {
    private MainActivity activity;
    private Button login, sigin;
    private TextView name, email, password, cpassword, date;
    public Signin(MainActivity activity){
        this.activity = activity;
        this.login = (Button) activity.findViewById(R.id.register_login_button);
        this.sigin = (Button) activity.findViewById(R.id.register_sigin_button);
        this.name = (TextView) activity.findViewById(R.id.register_field_name);
        this.email = (TextView) activity.findViewById(R.id.register_field_email);
        this.date = (TextView) activity.findViewById(R.id.register_date_field);
        this.password = (TextView) activity.findViewById(R.id.register_password_field);
        this.cpassword = (TextView) activity.findViewById(R.id.register_confirm_password_field);
        login.setOnClickListener( x -> {
            activity.setFlag(0);
        });
        sigin.setOnClickListener( x -> {
            if(Validator.validName(name.getText().toString())){
                boolean flag = true;
                flag = flag && Validator.validPassword(password.getText().toString());
                if(!flag){
                    Toast.makeText(activity, "La contraseña debe ser de 8 caracteres, tener al menos una mayuscula, una minuscula, un numero y un caracter especial",Toast.LENGTH_SHORT).show();
                }
                flag = flag && Validator.validPassword(cpassword.getText().toString());
                if(!flag){
                    Toast.makeText(activity, "La contraseña de confirmacion debe ser de 8 caracteres, tener al menos una mayuscula, una minuscula, un numero y un caracter especial",Toast.LENGTH_SHORT).show();
                }
                if(flag){
                    if(Validator.equalPasswords(password.getText().toString(), cpassword.getText().toString())){
                        if(date.getText().toString().matches("^(\\d{1,2}[/]){2}\\d{2,4}$")){
                            if(Validator.validEmail(email.getText().toString())){
                                try{
                                    Date fecha = new SimpleDateFormat("dd/MM/yyyy").parse(date.getText().toString());
                                    String day = date.getText().toString().split("/")[0];
                                    String month = Validator.numberToStringMonth(Integer.valueOf(date.getText().toString().split("/")[1]));
                                    String year = date.getText().toString().split("/")[2];
                                    String nombre = this.name.getText().toString();
                                    String email = this.email.getText().toString();
                                    String password = this.password.getText().toString();
                                    String cpassword = this.cpassword.getText().toString();
                                    webservice web = new webservice(activity);
                                    web.registerUser(nombre,email,password,cpassword,day,month,year);
                                    sigin.setEnabled(false);
                                }catch(Exception e){
                                    //Toast.makeText(activity, "Formato de fecha invalida", Toast.LENGTH_SHORT).show();
                                    Toast.makeText(activity, date.getText().toString(),Toast.LENGTH_SHORT).show();
                                }

                            }else{
                                Toast.makeText(activity, "email invalido", Toast.LENGTH_SHORT).show();
                            }
                        }else{
                            Toast.makeText(activity,date.getText().toString(),Toast.LENGTH_SHORT);
                        }

                    }else{
                        Toast.makeText(activity,"Las contraseñas no coinciden", Toast.LENGTH_SHORT).show();
                    }
                }

            }else{
                Toast.makeText(activity,"Nombre invalido", Toast.LENGTH_SHORT).show();
            }

        });


    }
}
