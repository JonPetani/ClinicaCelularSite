/**
 * @author Jonathan Petani
 * @version 1
 */
package com.example.clinicacelular;

import android.os.Build;
import androidx.annotation.RequiresApi;
import java.util.HashSet;
import java.util.HashMap;
import java.text.DecimalFormat;

public class Repair extends Service {

    private HashSet<String> OSes = new HashSet<String>();
    private HashSet<String> Devices = new HashSet<String>();
    private HashMap<String, String> Description = new HashMap<String, String>(); //Key is Descriptive Term and Value is the definition text tied to the Term
    private String repairServiceId = "";
    /**
     *
     * @param itemName
     * @param Price
     * @param itemId
     * @param itemIcon
     * @param serviceTimeEstimate
     * @param Category
     * @param Description
     * @param repairServiceId
     * @throws IllegalArgumentException
     */
    public Repair(String itemName, double Price, String itemId, String itemIcon, String serviceTimeEstimate, String Category, HashMap<String, String> Description, String repairServiceId) throws IllegalArgumentException{
        super(itemName, Price, itemId, itemIcon, serviceTimeEstimate, Category);
        if(Description == null || Description.isEmpty() == true)
            throw new IllegalArgumentException("Must be a summary of the service.");
        if(repairServiceId == null || repairServiceId.length() == 0)
            throw new IllegalArgumentException("Security code must be created.");
        this.Description.putAll(Description);
    }

    /**
     *
     * @param itemName
     * @param Price
     * @param itemId
     * @param itemIcon
     * @param serviceTimeEstimate
     * @param Category
     * @param OSes
     * @param Devices
     * @param Description
     * @param repairServiceId
     * @return Repair
     * @throws IllegalArgumentException
     */
    public static Repair create(String itemName, double Price, String itemId, String itemIcon,  String serviceTimeEstimate, String Category, HashSet<String> OSes, HashSet<String> Devices, HashMap<String, String> Description, String repairServiceId) throws IllegalArgumentException {
        Repair r = new Repair(itemName, Price, itemId, itemIcon, serviceTimeEstimate, Category, Description, repairServiceId);
        if((OSes == null || OSes.isEmpty() == true) && (Devices == null || Devices.isEmpty() == true))
            throw new IllegalArgumentException("Customers don't know which devices and/or operating systems this repair pertains to.");
        r.setDevicesApplicable(Devices);
        r.setOSesApplicable(OSes);
        return r;
    }

    /**
     *
     * @param Devices
     */
    public void setDevicesApplicable(HashSet<String> Devices) {
        if(Devices == null || Devices.isEmpty() == true)
            return;
        this.Devices.addAll(Devices);
    }

    /**
     *
     * @return Devices
     */
    public HashSet<String> getDevicesApplicable() {
        return Devices;
    }

    /**
     *
     * @param OSes
     */
    public void setOSesApplicable(HashSet<String> OSes) {
        if(OSes == null || OSes.isEmpty() == true)
            return;
        this.OSes.addAll(OSes);
    }

    /**
     *
     * @return OSes
     */
    public HashSet<String> getOSesApplicable() {
        return OSes;
    }

    /**
     *
     * @param Description
     */
    public void setDescription(HashMap<String, String> Description) {
        if(Description == null || Description.isEmpty() == true)
            return;
        this.Description.putAll(Description);
    }

    /**
     *
     * @return Description
     */
    public HashMap<String, String> getDescription() {
        return Description;
    }

    /**
     *
     * @param repairServiceId
     */
    public void setRepairServiceId(String repairServiceId) {
        if(repairServiceId == null || repairServiceId.length() == 0)
            return;
        this.repairServiceId = repairServiceId;
    }

    /**
     *
     * @return repairServiceId
     */
    public String getRepairServiceId() {
        return repairServiceId;
    }

    /**
     *
     * @return hashCode
     */
    @Override
    public int hashCode() {
        return this.repairServiceId.hashCode();
    }

    /**
     *
     * @param o
     * @return equality to Repair Data Type
     */
    @Override
    public boolean equals(Object o) {
        if(o == null || !(o instanceof Repair))
            return false;
        Repair r = (Repair) o;
        return this.repairServiceId == repairServiceId && this.getItemId() == getItemId();
    }

    /**
     *
     * @return Repairs Field String
     */
    @RequiresApi(api = Build.VERSION_CODES.N)
    @Override
    public String toString() {
        StringBuilder repairStr = new StringBuilder();
        DecimalFormat moneyFormat = new DecimalFormat("¤#.00");
        repairStr.append("| Item Id in System: " + getItemId());
        repairStr.append(",  Repair Title: " + getName());
        repairStr.append(", Price: " + moneyFormat.format(getPrice()));
        repairStr.append(", Service Icon Link: " + getItemIcon());
        repairStr.append(", Category: " + getCategory());
        repairStr.append(", Service Repair Id: " + repairServiceId);
        if(Devices.isEmpty() == false) {
            repairStr.append(", Devices this Repair pertains to(where applicable): {");
            Devices.forEach((String Device) -> {repairStr.append(" " + Device);});
            repairStr.append("}");
        }
        if(OSes.isEmpty() == false) {
            repairStr.append(", Operating Systems this Repair pertains to(where applicable): {");
            OSes.forEach((String OS) -> {repairStr.append("" + OS);});
            repairStr.append("}");
        }
        repairStr.append(", Descriptive Text of Repair: {");
        Description.forEach((key, value) -> {repairStr.append("[" + key + ":" + value + "]");});
        repairStr.append("}|");
        return repairStr.toString();
    }
}
