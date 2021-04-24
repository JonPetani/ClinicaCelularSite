/**
 * @author Jonathan Petani
 * @version 1
 */

package com.example.clinicacelular;
import android.os.Build;
import androidx.annotation.RequiresApi;
import java.util.HashMap;
import java.text.DecimalFormat;

public class Product extends Item {
    private String Brand = "";
    private int Supply = 0;
    private String productCode = ""; //extra id for sell-able stuff
    private HashMap<String, String> Specs = new HashMap<String, String>();
    private HashMap<String, String> Features = new HashMap<String, String>();
    /**
     *
     * @param itemName
     * @param Price
     * @param itemId
     * @param itemIcon
     * @param Brand
     * @param Supply
     * @param Category
     * @param productCode
     * @throws IllegalArgumentException
     */
    public Product(String itemName, double Price, String itemId, String itemIcon, String Brand, int Supply, String Category, String productCode) throws IllegalArgumentException{
        super(itemName, Price, itemId, itemIcon, Category);
        if(Brand == null || Brand.length() == 0)
            throw new IllegalArgumentException("All products must have their origin listed.");
        if(Supply < 0)
            throw new IllegalArgumentException("Can't be less than nothing of any product.");
        if(productCode == null || productCode.length() == 0)
            throw new IllegalArgumentException("Products in our inventory have unique codes for finding purposes.");
        this.Brand = Brand;
        this.Supply = Supply;
        this.productCode = productCode;
    }

    /**
     *
     * @param itemName
     * @param Price
     * @param itemId
     * @param itemIcon
     * @param Brand
     * @param Supply
     * @param Category
     * @param productImage
     * @param Specs
     * @param Features
     * @return a Sell-able Product
     */
    public static Product create(String itemName, double Price, String itemId, String itemIcon, String Brand, int Supply, String Category, String productImage, HashMap<String, String> Specs, String productCode, HashMap<String, String> Features) {
        Product p = new Product(itemName, Price, itemId, itemIcon, Brand, Supply, Category, productCode);
        p.addSpecs(Specs);
        p.addFeatures(Features);
        return p;
    }

    /**
     *
     * @param Brand
     */
    public void setBrand(String Brand) {
        if(Brand == null || Brand.length() == 0)
            return;
        this.Brand = Brand;
    }

    /**
     *
     * @return Brand
     */
    public String getBrand() {
        return Brand;
    }

    /**
     *
     * @param Supply
     */
    public void setSupply(int Supply) {
        if(Supply < 0)
            return;
        this.Supply = Supply;
    }

    /**
     *
     * @return Supply
     */
    public int getSupply() {
        return Supply;
    }

    /**
     *
     * @param productCode
     */
    public void setProductCode(String productCode) {
        if(productCode == null || productCode.length() == 0)
            return;
        this.productCode = productCode;
    }

    /**
     *
     * @return productCode
     */
    public String getProductCode() {
        return productCode;
    }

    /**
     * add all new items to Specs String Map
     * @param Specs
     */
    public void addSpecs(HashMap<String, String> Specs) {
        if(Specs == null || Specs.isEmpty() == true)
            return;
        this.Specs.putAll(Specs);
    }

    /**
     *
     * @return Specs Map
     */
    public HashMap<String, String> getSpecs() {
        return Specs;
    }

    /**
     *
     * @param Features
     */
    public void addFeatures(HashMap<String, String> Features) {
        if(Features == null || Features.isEmpty() == true)
            return;
        this.Features.putAll(Specs);
    }

    /**
     *
     * @return Features
     */
    public HashMap<String, String> getFeatures() {
        return Features;
    }

    /**
     *
     * @return hashcode
     */
    @Override
    public int hashCode() {
        return this.getItemId().hashCode();
    }

    /**
     *
     * @param o
     * @return equality to Product data type and it's superclass Item
     */
    @Override
    public boolean equals(Object o) {
        if(o == null | !(o instanceof Product))
            return false;
        Product p = (Product) o;
        return this.getItemId() == getItemId() ;
    }

    /**
     *
     * @return Products Field String
     */
    @RequiresApi(api = Build.VERSION_CODES.N)
    @Override
    public String toString() {
        StringBuilder ProductStr = new StringBuilder();
        DecimalFormat moneyFormat = new DecimalFormat("¤#.00");
        ProductStr.append("| Item Id in System: " + getItemId());
        ProductStr.append(", Product Name: " + getName());
        ProductStr.append(", Price: " + moneyFormat.format(getPrice()));
        ProductStr.append(", Product Icon Link: " + getItemIcon());
        ProductStr.append(", Brand/Maker of Product: " + Brand);
        ProductStr.append(", Current Stock of this Item: " + Supply);
        ProductStr.append(", This Product is Classified as: " + getCategory());
        if(Specs.isEmpty() == true) {
            ProductStr.append(", List of Specs(For Electronics Products): {");
            Specs.forEach((key, value) -> {ProductStr.append("[" + key + ":" + value + "]");});
            ProductStr.append("}");
        }
        if(Features.isEmpty() == true) {
            ProductStr.append(", List of Features/Info (For any Product): {");
            Features.forEach((key, value) -> {ProductStr.append("[" + key + ":" + value + "]");});
            ProductStr.append("}");
        }
        ProductStr.append(", Product Code: " + productCode + "|");
        return ProductStr.toString();
    }
}
