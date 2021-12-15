package com.example.mannyfoods;

import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;
import java.util.List;
import java.util.stream.Collectors;

public class compras {
    private MainActivity a;
    private RecyclerView recycler;
    private Button atras;
    private ArrayList<Inventario> inv;
    private Inventario selectedProduct;
    private webservice web;
    private String email;
    public compras(MainActivity _a, String _email){
        a = _a;
        recycler = (RecyclerView) a.findViewById(R.id.compras_showCompras);
        recycler.setLayoutManager(new LinearLayoutManager(a,LinearLayoutManager.VERTICAL,false));
        email = _email;
        atras = (Button) a.findViewById(R.id.compras_atras);
        atras.setOnClickListener(x -> {
            a.setFlag(2);
        });
        web = new webservice(a);
        web.getCompras(email,this);
        selectedProduct = null;
    }
    public void setCompras(ArrayList<Inventario> i){
        inv = i;
        double suma = i.stream().map(x -> x.getCantidadN() * x.getProducto().getPrecio()).collect(Collectors.toList()).stream().mapToDouble(X->X).sum();
        TextView text = (TextView) a.findViewById(R.id.compras_total);
        text.setText(String.format("Total: $%.2f",suma));
        AdapterProductos1 adpter = new AdapterProductos1(i);
        adpter.setPrefix("Por comprar: ");
        adpter.setEvt(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                selectedProduct = inv.get(recycler.getChildAdapterPosition(v));
                a.setFlag(5);
            }
        });
        recycler.setAdapter(adpter);
    }

    public Inventario getSelectedProduct() {
        return selectedProduct;
    }
}
