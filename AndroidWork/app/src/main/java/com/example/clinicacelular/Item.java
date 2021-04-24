/**
 * @version 1
 * @author Jonathan Petani
 */
package com.example.clinicacelular;

public class Item {
    protected String itemName = "";
    protected double Price = 0.0;
    protected String itemId = "";
    protected String itemIcon = "";
    protected String Category = "";
    /**
     *
     * @param itemName
     * @param Price
     * @param itemId
     * @param itemIcon
     * @param Category
     * @throws IllegalArgumentException
     */
    public Item(String itemName, double Price, String itemId, String itemIcon, String Category) throws IllegalArgumentException{
        if(itemName == null || itemName.length() == 0)
            throw new IllegalArgumentException("This item was given no name. Without there is no way of knowing what it is.");
        if(Price <= 0.0)
            throw new IllegalArgumentException("Every product/service needs a price. You can't profit with giveaways.");
        if(itemId == null || itemId.length() == 0)
            throw new IllegalArgumentException("Items need unique id codes.");
        if(itemIcon == null || itemIcon.length() == 0)
            throw new IllegalArgumentException("All products require a image so the customers know what it looks like.");
        if(Category == null || Category.length() == 0)
            throw new IllegalArgumentException("Set a Category for each Item for sorting purposes on the App.");
        this.itemName = itemName;
        this.Price = Price;
        this.itemId = itemId;
        this.itemIcon = itemIcon;
        this.Category = Category;
    }

    /**
     *
     * @param itemName
     */
    public void setName(String itemName) {
        this.itemName = itemName;
    }

    /**
     *
     * @return itemName
     */
    public String getName() {
        return itemName;
    }

    /**
     *
     * @param Price
     */
    public void setPrice(double Price) {
        this.Price = Price;
    }

    /**
     *
     * @return Price
     */
    public double getPrice() {
        return Price;
    }

    /**
     *
     * @param itemId
     */
    public void setItemId(String itemId){
        this.itemId = itemId;
    }

    /**
     *
     * @return itemId
     */
    public String getItemId() {
        return itemId;
    }

    /**
     *
     * @param itemIcon
     */
    public void setItemIcon(String itemIcon) {
        this.itemIcon = itemIcon;
    }

    /**
     *
     * @return itemIcon
     */
    public String getItemIcon() {
        return itemIcon;
    }

    /**
     *
     * @param Category
     */
    public void setCategory(String Category) {
        this.Category = Category;
    }

    /**
     *
     * @return Category
     */
    public String getCategory() {
        return Category;
    }
}
