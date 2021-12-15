package com.example.mannyfoods;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;

public class AdapterProductos1 extends RecyclerView.Adapter<AdapterProductos1.ViewHolderProductos1>{

    private ArrayList<Inventario> list;
    private View.OnClickListener evt;
    public AdapterProductos1(ArrayList<Inventario> l){
        this.list = l;
        prefix = "Disponible ";
    }
    private String prefix;
    @NonNull
    @Override
    public ViewHolderProductos1 onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.elmento_inventario,null,false);
        view.setOnClickListener(evt);
        return new ViewHolderProductos1(view);
    }
    public void setPrefix(String s){
        prefix = s;
    }
    @Override
    public void onBindViewHolder(@NonNull ViewHolderProductos1 holder, int position) {
        holder.setCantidad(prefix + list.get(position).getCantidad());
        holder.setMinimo("minimo: "+list.get(position).getMinimo());
        holder.setNombre(list.get(position).getProducto().getNombre());

    }
    public void setEvt(View.OnClickListener _evt){
        this.evt = _evt;
    }
    @Override
    public int getItemCount() {
        return list.size();
    }
    public class ViewHolderProductos1 extends RecyclerView.ViewHolder {
        private TextView txt1;
        private TextView txt2;
        private TextView txt3;
        public ViewHolderProductos1(@NonNull View itemView) {
            super(itemView);
            txt1 = (TextView) itemView.findViewById(R.id.inv_nombre);
            txt2 = (TextView) itemView.findViewById(R.id.inv_cantidad);
            txt3 = (TextView) itemView.findViewById(R.id.inv_min);

        }
        public void setNombre(String nombre) {
            txt1.setText(nombre);
        }
        public void setCantidad(String cantidad){
            txt2.setText(cantidad);
        }
        public void setMinimo(String min){
            txt3.setText(min);
        }
    }
}
