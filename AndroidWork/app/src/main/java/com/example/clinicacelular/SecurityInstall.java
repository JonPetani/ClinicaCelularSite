/**
 * @author Jonathan Petani
 * @version 1
 */
package com.example.clinicacelular;
import android.os.Build;
import androidx.annotation.RequiresApi;
import java.util.HashSet;
import java.text.DecimalFormat;

public class SecurityInstall extends Service {

    private String setUpLocationType = "";
    private String securitySystemBrand = "";
    private String securitySystemModel = "";
    private boolean mobileIntegrated = false;
    private HashSet<String> systemPerks = new HashSet<String>(); //bullet list of perks for this particular system to install
    private String securityServiceId = "";

    /**
     *
     * @param itemName
     * @param Price
     * @param itemId
     * @param itemIcon
     * @param serviceTimeEstimate
     * @param Category
     * @param securitySystemBrand
     * @param mobileIntegrated
     * @param securityServiceId
     * @param securitySystemModel
     * @throws IllegalArgumentException
     */
    public SecurityInstall(String itemName, double Price, String itemId, String itemIcon, String serviceTimeEstimate, String Category, String securitySystemBrand, boolean mobileIntegrated, String securityServiceId, String securitySystemModel) throws IllegalArgumentException{
        super(itemName, Price, itemId, itemIcon, serviceTimeEstimate, Category);
        if(securitySystemBrand == null || securitySystemBrand.length() == 0)
            throw new IllegalArgumentException("Brand info must be listed.");
        if(mobileIntegrated != false && mobileIntegrated != true)
            throw new IllegalArgumentException("Customer must know if it has mobile integration");
        if(securityServiceId == null || securityServiceId.length() == 0)
            throw new IllegalArgumentException("Unique Repair Service Id must exist.");
        if(securitySystemModel == null || securitySystemModel.length() == 0)
            throw new IllegalArgumentException("Model needs to be listed.");
        this.securitySystemBrand = securitySystemBrand;
        this.mobileIntegrated = mobileIntegrated;
        this.securityServiceId = securityServiceId;
        this.securitySystemModel = securitySystemModel;
    }

    /**
     *
     * @param itemName
     * @param Price
     * @param itemId
     * @param itemIcon
     * @param serviceTimeEstimate
     * @param Category
     * @param securitySystemBrand
     * @param mobileIntegrated
     * @param setUpLocationType
     * @param systemPerks
     * @param securityServiceId
     * @param securitySystemModel
     * @return Security Install Protocol
     */
    public static SecurityInstall create(String itemName, double Price, String itemId, String itemIcon, String serviceTimeEstimate, String Category, String securitySystemBrand, boolean mobileIntegrated, String setUpLocationType, HashSet<String> systemPerks, String securityServiceId, String securitySystemModel) {
        SecurityInstall si = new SecurityInstall(itemName, Price, itemId, itemIcon, serviceTimeEstimate, Category, securitySystemBrand, mobileIntegrated, securityServiceId, securitySystemModel);
        si.setSetUpLocationType(setUpLocationType);
        si.setSystemPerks(systemPerks);
        return si;
    }

    /**
     *
     * @param setUpLocationType
     */
    public void setSetUpLocationType(String setUpLocationType) {
        if(setUpLocationType == null || setUpLocationType.length() == 0)
            return;
        this.setUpLocationType = setUpLocationType;
    }

    /**
     *
     * @return setUpLocationType
     */
    public String getSetUpLocationType() {
        return setUpLocationType;
    }

    /**
     *
     * @param securitySystemBrand
     */
    public void setSecuritySystemBrand(String securitySystemBrand) {
        if(securitySystemBrand == null || securitySystemBrand.length() == 0)
            return;
        this.securitySystemBrand = securitySystemBrand;
    }

    /**
     *
     * @return securitySystemBrand
     */
    public String getSecuritySystemBrand() {
        return securitySystemBrand;
    }

    /**
     *
     * @param mobileIntegrated
     */
    public void setMobileIntegrated(boolean mobileIntegrated) {
        if(mobileIntegrated != true && mobileIntegrated != false)
            return;
        this.mobileIntegrated = mobileIntegrated;
    }

    /**
     *
     * @return mobileIntegrated
     */
    public boolean getMobileIntegrated() {
        return mobileIntegrated;
    }

    /**
     *
     * @param systemPerks
     */
    public void setSystemPerks(HashSet<String> systemPerks) {
        if(systemPerks == null || systemPerks.isEmpty() == true)
            return;
        this.systemPerks.addAll(systemPerks);
    }

    /**
     *
     * @return systemPerks
     */
    public HashSet<String> getSystemPerks() {
        return systemPerks;
    }

    /**
     *
     * @param securityServiceId
     */
    public void setSecurityServiceId(String securityServiceId) {
        if(securityServiceId == null || securityServiceId.length() == 0)
            return;
        this.securityServiceId = securityServiceId;
    }

    /**
     *
     * @return securityServiceId
     */
    public String getSecurityServiceId() {
        return securityServiceId;
    }

    /**
     *
     * @param securitySystemModel
     */
    public void setSecuritySystemModel(String securitySystemModel) {
        if(securitySystemModel == null || securitySystemModel.length() == 0)
        this.securitySystemModel = securitySystemModel;
    }

    /**
     *
     * @return securitySystemModel
     */
    public String getSecuritySystemModel() {
        return securitySystemModel;
    }

    /**
     *
     * @return hashCode
     */
    @Override
    public int hashCode() {
        return this.securityServiceId.hashCode();
    }

    /**
     *
     * @param o
     * @return Equality to SecurityInstall data type
     */
    @Override
    public boolean equals(Object o) {
        if(o == null || !(o instanceof SecurityInstall))
            return false;
        SecurityInstall si = (SecurityInstall) o;
        return this.securityServiceId == securityServiceId && this.getItemId() == getItemId();
    }

    /**
     *
     * @return SecurityInstalls field string
     */
    @RequiresApi(api = Build.VERSION_CODES.N)
    @Override
    public String toString() {
        StringBuilder securityStr = new StringBuilder();
        DecimalFormat moneyFormat = new DecimalFormat("¤#.00");
        securityStr.append("| Item Id in System: " + getItemId());
        securityStr.append(",  Service Title: " + getName());
        securityStr.append(", Price: " + getPrice());
        securityStr.append(", Service Icon Link: " + getItemIcon());
        securityStr.append(", Category: " + getCategory());
        if(setUpLocationType != null && setUpLocationType.length() > 0)
            securityStr.append(", Building-Type this System will be installed to specifically: " + setUpLocationType);
        else
            securityStr.append(", Building-Type this System will be installed to specifically: No Specific one listed");
        securityStr.append(", Brand of the Security System: " + securitySystemBrand);
        securityStr.append(", Model of the Security System: " + securitySystemModel);
        if(mobileIntegrated == true)
            securityStr.append(", Customer can interact with Security System using phone?: Yes");
        else
            securityStr.append(", Customer can interact with Security System using phone?: No");
        securityStr.append(", List of Perks for Customers choosing this System of Security: {");
        systemPerks.forEach((String Perk) -> {securityStr.append(" " + Perk);});
        securityStr.append("}");
        securityStr.append(", Security Service Id: " + securityServiceId + "|");
        return securityStr.toString();
    }
}
