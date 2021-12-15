package com.example.mannyfoods;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

public class webservice {
    private static String URL = "http://192.168.100.28/curso/ManyFoods/api.php";
    private MainActivity activity;
    private RequestQueue requestQueue;
    private Login login;
    private Signin signin;
    private añadirProducto t;
    public StringRequest request;

    public webservice(MainActivity act) {
        activity = act;
        requestQueue = Volley.newRequestQueue(activity);
    }
    public void login(String email, String password, Login log) {

        this.login = log;
        HashMap headers = new HashMap();
        headers.put("action", "login");
        headers.put("email", email);
        headers.put("password", MD5.build(password));
        headers.put("Content-Type","application/x-www-form-urlencoded");
        request = generatePostRequest(
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) { //En caso de tener exito
                        try {
                            JSONObject obj = new JSONObject(response);
                            int status = obj.getInt("status");
                            if(status == 200 || status == 400){
                                boolean logStatus = obj.getBoolean("login");
                                if(logStatus){
                                    String uiid = obj.getString("uuid");
                                    String name = obj.getString("name");
                                    int day = obj.getInt("day");
                                    String month = obj.getString("month");
                                    int year = obj.getInt("year");
                                    Toast.makeText(activity,"Bienvenido", Toast.LENGTH_SHORT).show();
                                    activity.setSessionAttribute("email",email);
                                    activity.setSessionAttribute("uuid",uiid);
                                    activity.setSessionAttribute("name",name);
                                    activity.setSessionAttribute("day",String.valueOf(day));
                                    activity.setSessionAttribute("monnth",month);
                                    activity.setSessionAttribute("year",String.valueOf(year));
                                    activity.setSuccesOnLogin(true);
                                }else{
                                    Toast.makeText(activity,"Email y/o password incorrecto", Toast.LENGTH_SHORT).show();
                                    log.setBlankPassword();
                                }
                                activity.setFlag(2);
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();

                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) { //En caso de error
                        Toast.makeText(activity, "No se pudo contactar con el servidor...",Toast.LENGTH_SHORT).show();
                    }
                },
                headers //Enviamos el encabezado
        );
        sendRequest(request);
    }
    public void getInventario(String email,dashboard dash){
        ArrayList<Inventario> inventario = new ArrayList<>();
        HashMap headers = new HashMap<String,String>(){
            {
                put("action","getInventario");
                put("email",email);
            }
        };
        request = generatePostRequest(
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject obj = new JSONObject(response);
                            int status = obj.getInt("status");
                            if(status == 200){
                                int cantidad_productos = obj.getInt("cantidad productos");
                                if(cantidad_productos>0){
                                    for(int i = 0; i<cantidad_productos; i++){
                                        JSONObject item = obj.getJSONObject(String.valueOf(i));
                                        int id = item.getInt("id"),
                                                cantidad = item.getInt("cantidad"),
                                                minimo = item.getInt("minimo"),
                                                departamento = item.getInt("departamento"),
                                                subdepartamento = item.getInt("subdepartamento");
                                        double precio = item.getDouble("precio");
                                        String nombre = item.getString("nombre");
                                        Producto producto = new Producto(id,nombre,departamento,subdepartamento,precio);
                                        Inventario inv = new Inventario(producto,cantidad,minimo);
                                        inventario.add(inv);
                                    }
                                    dash.setInvetory(inventario);
                                }
                            }else{
                                printMessage("No hay productos disponibles");
                            }
                        }catch(Exception e){
                            printMessage(e.toString());
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        printMessage("Servidores temporalmente no disponibles");
                    }
                },
                headers);
        sendRequest(request);
    }
    public void getCompras(String email,compras c){
        ArrayList<Inventario> inventario = new ArrayList<>();
        HashMap headers = new HashMap<String,String>(){
            {
                put("action","getCompras");
                put("email",email);
            }
        };
        request = generatePostRequest(
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject obj = new JSONObject(response);
                            int status = obj.getInt("status");
                            if(status == 200){
                                int cantidad_productos = obj.getInt("cantidad");
                                if(cantidad_productos>0){
                                    for(int i = 0; i<cantidad_productos; i++){
                                        JSONObject item = obj.getJSONObject(String.valueOf(i));
                                        int id = item.getInt("id"),
                                                cantidad = item.getInt("comprar"),
                                                minimo = item.getInt("minimo"),
                                                departamento = item.getInt("departamento"),
                                                subdepartamento = item.getInt("subdepartamento");
                                        double precio = item.getDouble("precio");
                                        String nombre = item.getString("nombre");
                                        Producto producto = new Producto(id,nombre,departamento,subdepartamento,precio);
                                        Inventario inv = new Inventario(producto,cantidad,minimo);
                                        inventario.add(inv);
                                    }
                                    c.setCompras(inventario);
                                }
                            }else{
                                printMessage("No hay productos disponibles");
                            }
                        }catch(Exception e){
                            printMessage(e.toString());
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        printMessage("Servidores temporalmente no disponibles");
                    }
                },
                headers);
        sendRequest(request);
    }
    public void registerUser(String name, String email, String password, String cpassword, String day, String month, String year){
        HashMap headers = new HashMap();
        headers.put("action","register");
        headers.put("name",name);
        headers.put("email",email);
        headers.put("password",password);
        headers.put("cpassword",cpassword);
        headers.put("day",day);
        headers.put("month",month);
        headers.put("year",year);
        request = generatePostRequest(new Response.Listener<String>() {
                                          @Override
                                          public void onResponse(String response) {
                                              try{
                                                  JSONObject obj = new JSONObject(response);
                                                  int status = obj.getInt("status");
                                                  if(status == 200){
                                                      printMessage("Registro exitoso");

                                                  }else if(status == 400){
                                                      printMessage("Usted ya se ha registrado previamente");
                                                  }else{
                                                      printMessage(String.valueOf(status));
                                                  }
                                              }catch(Exception e){
                                                  System.out.println(e);
                                              }
                                              try{
                                                  Thread.sleep(1000);
                                                  activity.setFlag(0);
                                              }catch(InterruptedException e){

                                              }

                                          }
                                      }, new Response.ErrorListener() {
                                          @Override
                                          public void onErrorResponse(VolleyError error) {
                                              System.out.println(error);
                                              activity.setFlag(0);
                                              printMessage(error.toString());
                                          }
                                      },
                headers);
        sendRequest(request);
    }

    public void delete_existencia(String email, int id_product, int cantidad){
        HashMap headers = new HashMap(){{put("action","eliminarExistencia");put("email",email);put("id",String.valueOf(id_product));put("cantidad",String.valueOf(cantidad));}};
        request = generatePostRequest(new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject obj = new JSONObject(response);
                    int status = obj.getInt("status");
                    if(status == 200){
                        activity.printMessage("Items eliminados del inventario");
                    }else{
                        activity.printMessage("Los items no fueron eliminados del inventario");
                    }
                } catch (JSONException e) {
                    activity.printMessage(e.toString());
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        },headers);
        sendRequest(request);
    }
    public void agregarinventario(String email, int id_product){
        HashMap headers = new HashMap(){{put("action","AGREGARINVENTARIO");put("email",email);put("id",String.valueOf(id_product));}};
        request = generatePostRequest(new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    activity.printMessage(response);
                    JSONObject obj = new JSONObject(response);
                    int status = obj.getInt("status");
                    if(status == 200){
                        activity.printMessage("Items han sido agregados a tu inventario");
                    }else{
                        activity.printMessage("Los items no fueron agregados al inventario");
                    }
                } catch (JSONException e) {
                    activity.printMessage(e.toString());
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        },headers);
        sendRequest(request);
    }
    public void eliminarcompra(String email, int id_product){
        HashMap headers = new HashMap(){{put("action","ELIMINARCOMPRA");put("email",email);put("id",String.valueOf(id_product));}};
        request = generatePostRequest(new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject obj = new JSONObject(response);
                    int status = obj.getInt("status");
                    if(status == 200){
                        activity.printMessage("Items han sido eliminados de tu lista de compras");
                    }else{
                        activity.printMessage("Los items no han sido eliminados de tu lista de compras");
                    }
                } catch (JSONException e) {
                    activity.printMessage(e.toString());
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        },headers);
        sendRequest(request);
    }

    public void setDSD(añadirProducto _t){
        HashMap headers = new HashMap(){{put("action","GETAVAILABLEDEPARTMENTS");}};
        ArrayList<Departamento> depts = new ArrayList<>();
        depts.add(new Departamento(-1,"Sin seleccionar"));
        this.t = _t;
        request = generatePostRequest(new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {

                    JSONObject obj = new JSONObject(response);
                    int status = obj.getInt("status");
                    if(status == 200){
                        int size = obj.getInt("size");
                        if(size > 0){
                            JSONArray arr = obj.getJSONArray("departments");
                            for(int var = 0; var<size; var++){
                                JSONObject dept  = arr.getJSONObject(var);
                                int id = dept.getInt("ID");
                                String nombre = dept.getString("NOMBRE");
                                depts.add(new Departamento(id,nombre));
                            }
                            t.setDepts(depts);
                            activity.printMessage("Se han cargado los departamentos");
                        }else{
                            activity.printMessage("No se pudo cargar los departamentos");
                        }
                    }else{
                        activity.printMessage("No se pudo cargar los departamentos");
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                    Toast.makeText(activity,e.toString(),Toast.LENGTH_LONG).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                activity.printMessage("Error al pedir departamentos 2");
            }
        },headers);
        sendRequest(request);
    }

    public void setSubD(añadirProducto _t,String department){
        HashMap headers = new HashMap(){{put("action","GETSUBDEPARTMENTS");put("department",department);}};
        ArrayList<Subdepartamento> depts = new ArrayList<>();
        this.t = _t;
        depts.add(new Subdepartamento(-1,"Sin seleccionar"));
        request = generatePostRequest(new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject obj = new JSONObject(response);
                    int status = obj.getInt("status");
                    if(status == 200){
                        JSONObject sub = obj.getJSONObject("sub");
                        Iterator<String> it = sub.keys();
                        while(it.hasNext()){
                            String key = it.next();
                            String subd = sub.getString(key);
                            Subdepartamento s = new Subdepartamento(Integer.valueOf(key),subd);
                            depts.add(s);
                        }
                        t.setSubdepts(depts);
                        activity.printMessage("Se han cargado los subdepartamentos");
                    }else{
                        activity.printMessage("No se pudo cargar los subdepartamentos");
                    }
                }catch (Exception e){
                    activity.printMessage("No se pudo cargar los subdepartamentos 2");
                    Toast.makeText(activity,e.toString(),Toast.LENGTH_LONG).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                activity.printMessage("Servidor no disponible temporalmente");

            }
        },headers);
        sendRequest(request);
    }
    public void getProducts(añadirProducto _t, String departamento, String subdepartamento){
        HashMap headers = new HashMap(){{put("action","GETPRODUCTS");put("department",departamento);put("subdepartment",subdepartamento);}};
        ArrayList<Producto> productos = new ArrayList<>();
        this.t = _t;
        productos.add(new Producto(-1,"Sin seleccionar",-1,-1,0.00));
        request = generatePostRequest(new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject obj = new JSONObject(response);
                    int status = obj.getInt("status");
                    if(status == 200){
                        JSONObject list = obj.getJSONObject("products");
                        Iterator<String> it = list.keys();
                        while(it.hasNext()){
                            String key = it.next();
                            JSONArray o = list.getJSONArray(key);
                            int id = o.getInt(0);
                            String nombre = o.getString(1);
                            double precio = o.getDouble(2);
                            productos.add(new Producto(id,nombre,t.getActualDept(),t.getActualSubdept(),precio));
                        }
                    }
                    t.setInsertProduct(productos);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        },headers);
        sendRequest(request);
    }

    public void insertCompras(String department, String subdepartment, String producto, String cantidad, String minimo){
        HashMap headers = new HashMap(){{put("action","INSERTCOMPRA");put("email", activity.getSessionAttribute("email"));put("department",department);put("subdepartment",subdepartment);put("producto",producto);put("cantidad",cantidad);put("minimo",minimo);}};
        request = generatePostRequest(new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject obj = new JSONObject(response);
                    Toast.makeText(activity,response,Toast.LENGTH_LONG).show();
                    if(obj.getInt("status") == 200){
                        activity.setFlag(2);
                        activity.printMessage("Producto agregado a tus compras");
                    }else{
                        activity.printMessage("El producto no fue agregado a tus compras");
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                    activity.printMessage("Ohh, ha surigido una excepcion");
                }

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        },headers);
        sendRequest(request);
    }

    private static StringRequest generatePostRequest(Response.Listener<String> listener, Response.ErrorListener error, HashMap<String, String> map) {

        return new StringRequest(Request.Method.POST, URL, listener, error) {
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                return map;
            }
        };
    }


    public void printMessage(String message){
        Toast.makeText(activity,message,Toast.LENGTH_SHORT).show();
    }
    private void sendRequest(StringRequest request) {
        requestQueue.add(request);
    }
}
