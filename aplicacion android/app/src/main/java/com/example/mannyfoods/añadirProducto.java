package com.example.mannyfoods;

import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;
import java.util.ArrayList;
import java.util.HashMap;

public class añadirProducto {
    private MainActivity a;
    private Button b,c,d,e,f,g;
    private TextView h,i;
    private Spinner j,k,l;
    private int actualDept, actualSubdept;
    private Producto selectedProduct;
    private String act1, act2;
    private int min, cant;
    //private HashMap<Departamento, ArrayList<Subdepartamento>> hashMap;
    private ArrayList<Departamento> depts;
    private ArrayList<Subdepartamento> sdepts;
    private ArrayList<Producto> productos;
    webservice web;
    public añadirProducto(MainActivity a) {
        this.a = a;
        min = 1;
        cant = 1;
        //Seteando los botones
        b = (Button) a.findViewById(R.id.ac_atras);
        c = (Button) a.findViewById(R.id.ac_aceptar);
        c.setOnClickListener(x -> {
            if(actualSubdept > 0 && actualSubdept > 0 && selectedProduct != null){
                web.insertCompras(String.valueOf(selectedProduct.getDept()),String.valueOf(selectedProduct.getSubdept()),String.valueOf(selectedProduct.getId()),String.valueOf(cant),String.valueOf(min));
            }else{
                if(actualSubdept<=0){
                    a.printMessage("Ingrese un subdepartamento");
                }
                if(actualDept<=0){
                    a.printMessage("Ingrese un departamento");
                }
                if(actualSubdept>0){
                    if(selectedProduct == null){
                        a.printMessage("Seleccione un producto");
                    }
                }
            }

        });
        d = (Button) a.findViewById(R.id.ac_mi);
        e = (Button) a.findViewById(R.id.ac_ai);
        d.setOnClickListener(x->{
            changeAmount1(-1);
        });
        e.setOnClickListener(x->{
            changeAmount1(1);
        });
        f = (Button) a.findViewById(R.id.ac_mm);
        g = (Button) a.findViewById(R.id.ac_am);
        f.setOnClickListener(x -> {
            changeAmount2(-1);
        });
        g.setOnClickListener(s->{
            changeAmount2(1);
        });
        b.setOnClickListener(x -> {
            a.setFlag(2);
        });
        // Agregando los textview
        h = (TextView) a.findViewById(R.id.ac_i);
        i = (TextView) a.findViewById(R.id.ac_m);
        changeAmount2(0);
        changeAmount1(0);
        // Modificando los Spinners
        j = (Spinner) a.findViewById(R.id.ac_dept);
        k = (Spinner) a.findViewById(R.id.ac_subdept);
        l = (Spinner) a.findViewById(R.id.ac_product);
        //Llamando a los webservices

        actualDept = -1;
        actualSubdept = -1;
        web = new webservice(a);
        web.setDSD(this);
    }
    public void setDepts(ArrayList<Departamento> dept){
        añadirProducto tmp = this;
        this.depts = dept;
        ArrayAdapter<Departamento> adapter = new ArrayAdapter<Departamento>(a,android.R.layout.simple_spinner_item,dept);
        j.setAdapter(adapter);
        j.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                Departamento d = depts.get(position);
                if(d.getDept() > 0){
                    selectedProduct = null;
                    act2 = "";
                    String department = dept.get(position).getNombre();
                    act1 = dept.get(position).getNombre();
                    actualDept = dept.get(position).getDept();
                    actualSubdept = -1;
                    insertDepartments(department);
                }else{
                    ArrayList<Subdepartamento> s = new ArrayList<>();
                    setSubdepts(s);
                    actualDept = -1;
                    actualSubdept = -1;
                    selectedProduct = null;
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
    }
    public void setSubdepts(ArrayList<Subdepartamento> sdept){
        this.sdepts = sdept;
        ArrayAdapter<Subdepartamento> arr = new ArrayAdapter<Subdepartamento>(a, android.R.layout.simple_spinner_item,sdept);
        k.setAdapter(arr);
        k.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                selectedProduct = null;
                actualSubdept= sdept.get(position).getSdept();
                act2 = sdept.get(position).getNombre();
                insertProducts(act1,act2);
            }
            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
    }

    public int getActualDept() {
        return actualDept;
    }

    public int getActualSubdept() {
        return actualSubdept;
    }

    public void insertDepartments(String departamento){
        web.setSubD(this, departamento);
    }

    public void setInsertProduct(ArrayList<Producto> arr){
        this.productos = arr;
        ArrayAdapter<Producto> at = new ArrayAdapter<>(a,android.R.layout.simple_spinner_item,arr);
        l.setAdapter(at);
        l.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                selectedProduct = arr.get(position);
                if(selectedProduct.getNombre().equals("Sin seleccionar")){
                    selectedProduct = null;
                }
            }
            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
    }

    public void insertProducts(String department, String subdepartment){
        web.getProducts(this,department,subdepartment);
    }
    private void changeAmount1(int i){
        if((i < 0 && cant>1) || i>0)
            cant += i;
        h.setText(String.valueOf(cant));
    }
    private void changeAmount2(int e){
        if((e < 0 && min>1) || e>0)
            min += e;
        i.setText(String.valueOf(min));
    }
}
