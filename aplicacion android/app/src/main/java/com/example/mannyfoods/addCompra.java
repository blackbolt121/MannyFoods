package com.example.mannyfoods;

import android.widget.Button;
import android.widget.TextView;

import org.w3c.dom.Text;

public class addCompra {
    private MainActivity a;
    private Inventario product;
    private TextView b, c, d;
    private Button e,f,g;
    private webservice web;
    public addCompra(MainActivity a, Inventario product) {
        this.a = a;
        this.product = product;
        b = (TextView) a.findViewById(R.id.pc_name);
        c = (TextView) a.findViewById(R.id.pc_cant);
        d = (TextView) a.findViewById(R.id.pc_min);
        e = (Button) a.findViewById(R.id.pc_cancelar);
        f = (Button) a.findViewById(R.id.pc_eliminar);
        g = (Button) a.findViewById(R.id.pc_aceptar);
        b.setText(product.getProducto().getNombre());
        c.setText(product.getCantidad());
        d.setText(product.getMinimo());
        web = new webservice(a);
        e.setOnClickListener(x -> {
            a.setFlag(4);
        });
        f.setOnClickListener(x -> {
            web.eliminarcompra(a.getSessionAttribute("email"),product.getProducto().getId());
            a.setFlag(4);
        });
        g.setOnClickListener(x -> {
            web.agregarinventario(a.getSessionAttribute("email"),product.getProducto().getId());
            a.setFlag(4);
        });
    }
}
