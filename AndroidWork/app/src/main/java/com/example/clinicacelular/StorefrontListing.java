/**
 * @author Jonathan Petani
 * @version 1
 */

package com.example.clinicacelular;
import android.os.Build;
import androidx.annotation.RequiresApi;
import java.util.ArrayList;
import java.text.DecimalFormat;

public class StorefrontListing {

    private Owner CEO = null;
    private String listingName = "";
    private ArrayList<StoreFront> Stores = new ArrayList<StoreFront>();
    private double companyExpenses = 0.0;
    private double companyProfit = 0.0;

    /**
     *
     * @param CEO
     * @param listingName
     * @throws IllegalArgumentException
     */
    public StorefrontListing(Owner CEO, String listingName) throws IllegalArgumentException {
        if(CEO == null)
            throw new IllegalArgumentException("This Company has a CEO, must be listed here.");
        if(listingName == null || listingName.length() == 0)
            throw new IllegalArgumentException("This Listing ");
        this.CEO = CEO;
        this.listingName = listingName;
    }

    /**
     *
     * @param CEO
     */
    public void setCEO(Owner CEO) {
        if(CEO == null)
            return;
        this.CEO = CEO;
    }

    /**
     *
     * @return CEO
     */
    public Owner getCEO() {
        return CEO;
    }

    /**
     *
     * @param listingName
     */
    public void setListingName(String listingName) {
        if(listingName == null || listingName.length() == 0)
            return;
        this.listingName = listingName;
    }

    /**
     *
     * @return listingName
     */
    public String getListingName() {
        return listingName;
    }

    /**
     *
     * @param sf
     */
    public void removeStore(StoreFront sf) {
        if(sf == null)
            return;
        Stores.remove(sf);
    }

    /**
     *
     * @param sf
     */
    public void addStore(StoreFront sf) {
        if(sf == null)
            return;
        Stores.add(sf);
    }

    /**
     *
     * @return Store List
     */
    public ArrayList<StoreFront> findStores() {
        return Stores;
    }

    /**
     * Calculate Current Company Expenses
     */
    @RequiresApi(api = Build.VERSION_CODES.N)
    public void calculateCompanyExpenses() {
        if(companyExpenses != 0)
            companyExpenses = 0;
        Stores.forEach((StoreFront sf) -> {companyExpenses += sf.getCurrentCost();});
    }

    /**
     *
     * @return Company Expenses
     */
    public double getCompanyExpenses() {
        return companyExpenses;
    }

    /**
     *
     * @return hashCode
     */
    @Override
    public int hashCode() {
        return this.CEO.getSID().hashCode();
    }

    /**
     *
     * @param o
     * @return Equality to StoreFront Listing Data Type
     */
    @Override
    public boolean equals(Object o) {
        if(o == null || !(o instanceof StorefrontListing))
            return false;
        StorefrontListing sfl = (StorefrontListing) o;
        return this.CEO.getSID() == CEO.getSID();
    }

    /**
     *
     * @return Store Listing Field String
     */
    @RequiresApi(api = Build.VERSION_CODES.N)
    @Override
    public String toString() {
        StringBuilder listingStr = new StringBuilder();
        DecimalFormat moneyFormat = new DecimalFormat("¤#.00");
        listingStr.append("| CEO of Company's Name: " + CEO.getName());
        listingStr.append(", Name of store listing: " + listingName);
        if(Stores != null && Stores.isEmpty() == false) {
            listingStr.append(", All Store Fronts Owned by Company According to Address: {");
            Stores.forEach((StoreFront sf) -> {listingStr.append(" [" + sf.getAddress() + "]");});
            listingStr.append("}");
        }
        listingStr.append(", Our Company's total expenses: " + moneyFormat.format(companyExpenses));
        listingStr.append(", Our Company's Current Profit/Loss: " + moneyFormat.format(companyProfit) + "|");
        return listingStr.toString();
    }
}
