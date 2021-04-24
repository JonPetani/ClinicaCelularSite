/**
 * @author: Jonathan Petani
 * @version: 1
 */
package com.example.clinicacelular;

import android.os.Build;
import androidx.annotation.RequiresApi;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Date;
import java.text.DecimalFormat;
import java.util.Random;

public class StoreFront{

    //String Id Generation Bounds
    private static final int idLowerBound = 13;
    private static final int idUpperBound = 27;

    //ASCII Char Range for Id Generation
    private static final int asciiLowerBound = 42;
    private static final int asciiUpperBound = 122;

    private int storeNum = 0;
    private String Address = "";
    private String Manager = "";
    private int storeFloors = 0;
    private double currentCost = 0.0;
    private double currentProfit = 0.0;
    private HashMap<String, Double> costRunDown = new HashMap<String, Double>(); //Summary of All Store Costs
    private String phoneNumber = "";
    private HashMap<String, String> Hours = new HashMap<String, String>(); //Store Hours
    private ArrayList<Product> productsHere = new ArrayList<Product>(); //All Accessories and Electronics a Given S
    private ArrayList<Repair> repairsOffered = new ArrayList<Repair>(); //All Software/Hardware Repair Services a Given Store Provides
    private ArrayList<SecurityInstall> securityServicesOffered = new ArrayList<SecurityInstall>(); //All Security Installation Services a Given Store Provides
    private HashMap<String, Double> allCosts = new HashMap<String, Double>();
    private StorefrontListing storeListing = null;

    /**
     *
     * @param storeNum
     * @param Address
     * @param Manager
     * @param Hours
     * @throws IllegalArgumentException
     */
    public StoreFront(int storeNum, String Address, String Manager, HashMap<String, String> Hours) throws IllegalArgumentException{
        if(storeNum <= 0)
            throw new IllegalArgumentException("Store Numbers Start at 1.");
        if(Address == null || Address.length() == 0)
            throw new IllegalArgumentException("All stores have a Address.");
        if(Manager == null || Manager.length() == 0)
            throw new IllegalArgumentException("Store Fronts need a Manager to run it.");
        if(Hours == null || Hours.isEmpty() == true)
            throw new IllegalArgumentException("Customers need to know hours of operation.");
        this.storeNum = storeNum;
        this.Address = Address;
        this.Manager = Manager;
        this.Hours.putAll(Hours);
    }

    /**
     *
     * @param storeNum
     * @param Address
     * @param Manager
     * @param Hours
     * @param storeFloors
     * @param phoneNumber
     * @param storeListing
     * @return StoreFront
     */
    public static StoreFront create(int storeNum, String Address, String Manager, HashMap<String, String> Hours, int storeFloors, String phoneNumber, StorefrontListing storeListing) {
        StoreFront sf = new StoreFront(storeNum, Address, Manager, Hours);
        sf.setFloors(storeFloors);
        sf.setPhoneNumber(phoneNumber);
        return sf;
    }

    /**
     *
     * @param storeNum
     */
    public void setStoreNum(int storeNum) {
        if(storeNum <= 0)
            return;
        this.storeNum = storeNum;
    }

    /**
     *
     * @return StoreNum
     */
    public int getStoreNum() {
        return storeNum;
    }

    /**
     *
     * @param Address
     */
    public void setAddress(String Address) {
        if(Address == null || Address.length() == 0)
            return;
        this.Address = Address;
    }

    /**
     *
     * @return Address
     */
    public String getAddress() {
        return Address;
    }

    /**
     *
     * @param Manager
     */
    public void setManager(String Manager) {
        if(Manager == null || Manager.length() == 0)
            return;
        this.Manager = Manager;
    }

    /**
     *
     * @return Manager
     */
    public String getManager() {
        return Manager;
    }

    /**
     *
     * @param storeFloors
     */
    public void setFloors(int storeFloors) {
        if(storeFloors < 0)
            return;
        this.storeFloors = storeFloors;
    }

    /**
     *
     * @return storeFloors
     */
    public int getFloors() {
        return storeFloors;
    }


    public void setCurrentProfit() {

    }

    /**
     *
     * @return averageProfit
     */
    public double getCurrentProfit() {
        return currentProfit;
    }

    /**
     * Set Current Cost of Store this Month
     * Adds to the Map of all Costs for this Location
     */
    @RequiresApi(api = Build.VERSION_CODES.N)
    public void setCurrentCost() {
        if(currentCost != 0)
            currentCost = 0;
        costRunDown.forEach((String expense, Double loss) -> {currentCost += loss;});
        Date d = new Date();
        allCosts.put(d.toString(), currentCost);
    }


    /**
     *
     * @return averageCost
     */
    public double getCurrentCost() {
        return currentCost;
    }

    /**
     *
     * @return All Costs for each month at the Location
     */
    public HashMap<String, Double> getAllCosts() {
        return allCosts;
    }

    /**
     *
     * @param costRunDown
     */
    public void setExpenses(HashMap<String, Double> costRunDown) {
        if(costRunDown == null || costRunDown.isEmpty() == true)
            return;
        this.costRunDown.putAll(costRunDown);
    }

    /**
     *
     * @return costRunDown
     */
    public HashMap<String, Double> getExpenses() {
        return costRunDown;
    }

    /**
     *
     * @param phoneNumber
     */
    public void setPhoneNumber(String phoneNumber) {
        if(phoneNumber == null || phoneNumber.length() == 0)
            return;
        this.phoneNumber = phoneNumber;
    }

    /**
     *
     * @return phoneNumber
     */
    public String getPhoneNumber() {
        return phoneNumber;
    }

    /**
     *
     * @param Hours
     */
    public void changeHours(HashMap<String, String> Hours) {
        if(Hours == null || Hours.isEmpty() == true)
            return;
        this.Hours.putAll(Hours);
    }

    /**
     *
     * @return Hours
     */
    public HashMap<String, String> getHours() {
        return Hours;
    }

    /**
     *
     * @param storeListing
     */
    public void setStoreListing(StorefrontListing storeListing) {
        this.storeListing = storeListing;
    }

    /**
     *
     * @return storeListing
     */
    public StorefrontListing getStoreListing() {
        return storeListing;
    }

    /**
     * Remove Product from Inventory List
     * @param p
     */
    public void deleteProduct(Product p) {
        if(p == null)
            return;
        productsHere.remove(p);
    }

    /**
     * Add Product to Inventory List
     * @param p
     */
    public void addProduct(Product p) {
        if(p == null)
            return;
        p.setItemId(idGenerator());
        productsHere.add(p);
    }

    /**
     * Delete Repair Service from Service List
     * @param r
     */
    public void deleteRepair(Repair r) {
        if(r == null)
            return;
        repairsOffered.remove(r);
    }

    /**
     * Add Repair Service to Service List
     * @param r
     */
    public void addRepair(Repair r) {
        if(r == null)
            return;
        r.setItemId(idGenerator());
        repairsOffered.add(r);
    }

    /**
     * Remove Security Installation Service from Security Service List
     * @param si
     */
    public void deleteSecurityService(SecurityInstall si) {
        if(si == null)
            return;
        securityServicesOffered.remove(si);
    }

    /**
     * Add Security Installation Service to Security Service List
     * @param si
     */
    public void addSecurityService(SecurityInstall si) {
        if(si == null)
            return;
        securityServicesOffered.add(si);
    }

    /**
     *
     * @return product list for store
     */
    public ArrayList<Product> findProducts() {
        return productsHere;
    }

    /**
     *
     * @return repair service list for store
     */
    public ArrayList<Repair> findRepairServices() {
        return repairsOffered;
    }

    /**
     *
     * @return security installation service list for store
     */
    public ArrayList<SecurityInstall> findSecurityInstallationServices() {
        return securityServicesOffered;
    }

    private static String idGenerator() {
        Random r = new Random();
        char[] idString = new char[idLowerBound + r.nextInt(idUpperBound)];
        int insertChar = 0;
        for(char character : idString) {
            insertChar = asciiLowerBound + r.nextInt(asciiUpperBound);
            character = (char)insertChar;
        }
        return String.valueOf(idString);
    }

    /**
     *
     * @return hashCode
     */
    @Override
    public int hashCode() {
        return this.storeNum * 9;
    }

    /**
     *
     * @param o
     * @return Equality to StoreFront data type
     */
    @Override
    public boolean equals(Object o) {
        if(o == null || !(o instanceof StoreFront))
            return false;
        StoreFront sf = (StoreFront) o;
        return this.storeNum == storeNum;
    }

    /**
     *
     * @return Store Front Field String
     */
    @RequiresApi(api = Build.VERSION_CODES.N)
    @Override
    public String toString() {
        StringBuilder storeStr = new StringBuilder();
        DecimalFormat moneyFormat = new DecimalFormat("¤#.00");
        storeStr.append("| Store Number(in order of when opened): " + storeNum);
        storeStr.append(", Store Address: " + Address);
        storeStr.append(", Store Manager: " + Manager);
        storeStr.append(", Number of Floors at this Store Front: " + storeFloors);
        storeStr.append(", Amount of money lost this month at this location: " + moneyFormat.format(currentCost));
        storeStr.append(", Profit at this location this month: " + moneyFormat.format(currentProfit));
        if(costRunDown.isEmpty() == false) {
            storeStr.append(", All Particular Expenses that sum up to the total cost on average: {");
            costRunDown.forEach((expense, loss) -> {storeStr.append("[" + expense + ":" + moneyFormat.format(loss) + "]");});
            storeStr.append("}");
        }
        storeStr.append(", Store Phone Number: " + phoneNumber);
        storeStr.append(", Store Hours (including regular days and holidays etc): {");
        Hours.forEach((day, time) -> {storeStr.append("[" + day + ":" + time + "]");});
        storeStr.append("}");
        if(productsHere.isEmpty() == false) {
            storeStr.append(", Products sold here (product names/brands only): {");
            productsHere.forEach((Product p) -> {storeStr.append(" [Brand:" + p.getBrand() + ", Product Name:" + p.getName() + "]");});
            storeStr.append("}");
        }
        if(repairsOffered.isEmpty() == false) {
            storeStr.append(", Repair Services Location Provides: {");
            repairsOffered.forEach((Repair r) -> {storeStr.append(" " + r.getName());});
            storeStr.append("}");
        }
        if(securityServicesOffered.isEmpty() == false) {
            storeStr.append(", Security Installation Options Location Provides: {");
            securityServicesOffered.forEach((SecurityInstall si) -> {storeStr.append(" [System Brand:" + si.getSecuritySystemBrand() + ", Security System Model:" + si.getSecuritySystemModel() + "]");});
            storeStr.append("}");
        }
        storeStr.append("|");
        return storeStr.toString();
    }
}
