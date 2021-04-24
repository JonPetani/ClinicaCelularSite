/**
 * Represents Coupons
 * @version 1
 * @author Jonathan Petani
 */
package com.example.clinicacelular;
import android.os.Build;
import androidx.annotation.RequiresApi;
import java.util.HashSet;


//Class for Coupons
public class Coupon {

//Coupon Fields
private double Percentage = 0.0;
private String couponDesc = "";
private String startDate = "";
private String expireDate = "";
private String Icon = "";
private boolean Active = false;
private HashSet<String> productList = new HashSet<String>();
private String couponCode = "";
private int minItems = 0;

private Coupon() {}

    /**
     *
     * @param Percentage
     * @param couponDesc
     * @param Icon
     * @param Active
     * @param couponCode
     * @throws IllegalArgumentException
     */
    public Coupon(double Percentage, String couponDesc, String Icon, boolean Active, String couponCode) throws IllegalArgumentException{
        if (Percentage <= 0.0) {
            throw new IllegalArgumentException("Coupon has to have some effect on the purchase, else is virtually useless. No valid reference for Coupon Percentage off was provided.");
        }
        if (couponDesc == null || couponDesc.length() == 0) {
            throw new IllegalArgumentException("No Coupon Description Provided. No Idea What This Coupon is Supposed to do.");
        }
        if(Active != false && Active != true) {
            throw new IllegalArgumentException("Can't Tell if the Coupon is Activated or Not.");
        }
        if (Icon == null || Icon.length() == 0) {
            throw new IllegalArgumentException("No Image of Coupon Provided. Will not Display on App Correctly.");
        }
        if (couponCode == null || couponCode.length() == 0) {
            throw new IllegalArgumentException("The Coupon wasn't provided a unique ID. Will have referencing errors later on due to this.");
        }
        this.Percentage = Percentage;
        this.couponDesc = couponDesc;
        this.Icon = Icon;
        this.Active = Active;
        this.couponCode = couponCode;
    }

    /**
     *
     * @param productList
     * @param Percentage
     * @param couponDesc
     * @param Icon
     * @param Active
     * @param couponCode
     * @param startDate
     * @param expireDate
     * @return Coupon
     */
    public static Coupon create(HashSet<String> productList, int minItems, double Percentage, String couponDesc, String Icon, boolean Active, String couponCode, String startDate, String expireDate) {
        Coupon coupon = new Coupon(Percentage, couponDesc, Icon, Active, couponCode);
        setProductList(productList);
        setMinItems(minItems);
        setStartDate(startDate);
        setExpireDate(expireDate);
        return coupon;
    }

    /**
     *
     * @param productList
     */
    public void setProductList(HashSet<String> productList) {
        this.productList.addAll(productList);
    }

    /**
     *
     * @return productList
     */
    public HashSet<String> getProductList() {
        return productList;
    }

    /**
     *
     * @param minItems
     */
    public void setMinItems(int minItems) {
        this.minItems = minItems;
    }

    /**
     *
     * @return Minimum Num of Products to Activate Coupon
     */
    public int getMinItems() {
        return minItems;
    }

    /**
     *
     * @param Active
     */
    public void setActivity(boolean Active) {
        this.Active = Active;
    }

    /**
     *
     * @return Activity of Coupon
     */
    public boolean getActivity() {
        return Active;
    }

    /**
     *
     * @param startDate
     */
    public void setStartDate(String startDate) {
        this.startDate = startDate;
    }

    /**
     *
     * @return Coupon Beginning Date
     */
    public String getStartDate() {
        return startDate;
    }

    /**
     *
     * @param expireDate
     */
    public void setExpireDate(String expireDate) {
        this.expireDate = expireDate;
    }

    /**
     *
     * @return Coupon Expiration Date
     */
    public String getExpireDate() {
        return expireDate;
    }

    /**
     *
     * @param couponCode
     */
    public void setCouponCode(String couponCode) {
        this.couponCode = couponCode;
    }

    /**
     *
     * @return coupon Identifier
     */
    public String getCouponCode() {
        return couponCode;
    }

    /**
     *
     * @param Icon
     */
    public void setIcon(String Icon) {
        this.Icon = Icon;
    }

    /**
     *
     * @return Coupon Icon Image
     */
    public String getIcon() {
        return Icon;
    }

    /**
     *
     * @param couponDesc
     */
    public void setCouponDesc(String couponDesc) {
        this.couponDesc = couponDesc;
    }

    /**
     *
     * @return coupon Description
     */
    public String getCouponDesc() {
        return couponDesc;
    }

    /**
     *
     * @param Percentage
     */
    public void setPercentage(double Percentage) {
        this.Percentage = Percentage;
    }

    /**
     *
     * @return Percentage
     */
    public double getPercentage() {
        return Percentage;
    }
    /**
     *
     * @param o
     * @return equality to Coupon Data Type
     */
    @Override
    public boolean equals(Object o) {
        if(o == null || !(o instanceof Coupon))
            return false;
        Coupon C = (Coupon) o;
        return this.couponCode == C.couponCode;
    }

    /**
     *
     * @return hashcode
     */
    @Override
    public int hashCode() {
        return this.couponCode.hashCode();
    }

    /**
     *
     * @return Coupon Fields String
     */
    @RequiresApi(api = Build.VERSION_CODES.N)
    @Override
    public String toString() {
        final StringBuilder couponStr = new StringBuilder();
        couponStr.append("|Percent Off of given Service(s): " + (int)(Percentage * 100));
        couponStr.append(", Coupon Description/Coupon Text: " + couponDesc);
        couponStr.append(", Coupon Beginning Date(When was it activated): " + startDate);
        couponStr.append(" Coupon Expiration Date(When will the coupon expire(for now))" + expireDate);
        couponStr.append(", Coupon Image Icon Location: " + Icon);
        couponStr.append(", If the Coupon is Active(independent of Dates above[true=yes/false=no]): " + Active);
        if(productList.isEmpty() == false) {
            couponStr.append(", All Specific Products/Services Needed For Coupon to be used (If is general coupon, should be empty): {");
            productList.forEach((String term) -> couponStr.append(" " + term));
            couponStr.append("}");
        }
        couponStr.append(", Number of Services/Products needed if no specific ones are Listed: " + minItems);
        couponStr.append(", Coupon Id (String Code Identifier): " + couponCode + "|\n");
        return couponStr.toString();
    }
}
