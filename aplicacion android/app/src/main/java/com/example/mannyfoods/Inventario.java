package com.example.mannyfoods;

import java.util.ArrayList;

public class Inventario {
    private Producto p;
    private int cantidad;
    private int minimo;
    public Inventario(Producto _p, int _cantidad, int _minimo){
        p = _p;
        cantidad = _cantidad;
        minimo = _minimo;
    }

    public Producto getProducto() {
        return p;
    }

    public String getCantidad() {
        return String.valueOf(cantidad);
    }
    public int getCantidadN(){
        return cantidad;
    }
    public int getMinimoN(){
        return this.minimo;
    }
    public String getMinimo() {
        return String.valueOf(minimo);
    }

    public void setProducto(Producto p) {
        this.p = p;
    }

    public void setCantidad(int cantidad) {
        this.cantidad = cantidad;
    }

    public void setMinimo(int minimo) {
        this.minimo = minimo;
    }
}
