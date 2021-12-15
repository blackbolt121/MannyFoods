package com.example.mannyfoods;

import android.widget.Button;
import android.widget.TextView;

public class editInventory {
    private Inventario p;
    private Button minus, plus, aceptar, cancelar;
    private TextView nombre, minimo, cant, amount;
    private int cantidad, max;
    private MainActivity a;
    private webservice web;
    public editInventory(MainActivity _a, Inventario _p){
        a = _a;
        p = _p;
        int id[] = {R.id.edit_inv_minus,R.id.edit_inv_plus,R.id.edit_inv_aceptar,R.id.edit_inv_cancelar};
        max = p.getCantidadN();
        minus = getButton(id[0]);
        plus = getButton(id[1]);
        aceptar = getButton(id[2]);
        cancelar = getButton(id[3]);
        nombre = getTextView(R.id.editInv_prod_name);
        minimo = getTextView(R.id.edit_inv_min);
        cant = getTextView(R.id.edit_inv_cantidad);
        amount = getTextView(R.id.edit_inv_amount);
        nombre.setText(p.getProducto().getNombre());
        minimo.setText(p.getMinimo());
        cant.setText(p.getCantidad());
        cancelar.setOnClickListener(x -> {
            a.setFlag(2);
        });
        cantidad = 1;
        changeAmount(0);
        plus.setOnClickListener(x -> {
            changeAmount(1);
        });
        minus.setOnClickListener(x -> {
            changeAmount(-1);
        });
        web = new webservice(a);
        aceptar.setOnClickListener(x -> {
            web.delete_existencia(a.getSessionAttribute("email"),p.getProducto().getId(),cantidad);
            a.setFlag(2);
        });
    }
    private Button getButton(int i){
        return (Button) a.findViewById(i);
    }
    private void changeAmount(int i){
        if((i < 0 && cantidad>1) || (i>0 && cantidad<max))
            cantidad = cantidad + i;
        amount.setText(String.valueOf(cantidad));
    }
    private TextView getTextView(int i){
        return (TextView) a.findViewById(i);
    }

}
