package com.example.mannyfoods;

import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import java.util.ArrayList;

public class dashboard {
    private MainActivity a;
    private String user, uuid;
    private RecyclerView recycler;
    private Button refrescar, cs, compras, acompras;
    private ArrayList<Inventario> inv;
    private Inventario selectedProduct;
    webservice web;
    public dashboard(MainActivity _a, String _user, String _uuid){
        user = _user;
        a = _a;
        uuid = _uuid;
        refrescar = (Button) a.findViewById(R.id.dashboard_refrescar);
        cs = (Button) a.findViewById(R.id.dashboard_logout);
        recycler = (RecyclerView) a.findViewById(R.id.dashborad_recycler);
        recycler.setLayoutManager(new LinearLayoutManager(a,LinearLayoutManager.VERTICAL,false));
        selectedProduct = null;
        web = new webservice(a);
        web.getInventario(user,this);
        cs.setOnClickListener(x -> {
            a.logout();
            a.setFlag(0);
        });
        refrescar.setOnClickListener(x -> {
            updateInventario();
            a.printMessage("Refrescando contenido");
        });
        compras = (Button) a.findViewById(R.id.dashboard_compras);
        compras.setOnClickListener(x -> {
            a.setFlag(4);
        });
        acompras = (Button) a.findViewById(R.id.dashboard_acompras);
        acompras.setOnClickListener(x ->{
            a.setFlag(6);
        });

    }
    public void setInvetory(ArrayList<Inventario> i){
        inv = i;
        AdapterProductos1 adpter = new AdapterProductos1(i);
        adpter.setEvt(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                selectedProduct = inv.get(recycler.getChildAdapterPosition(v));
                a.setFlag(3);
            }
        });
        recycler.setAdapter(adpter);
    }
    public Inventario getSelectedProduct(){
        return selectedProduct;
    }
    public void updateInventario(){
        web.getInventario(user,this);
    }
    private void print(String message){
        Toast.makeText(a,message,Toast.LENGTH_SHORT).show();
    }
}
