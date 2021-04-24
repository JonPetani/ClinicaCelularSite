/**
 * @author Jonathan Petani
 * @version 1
 */
package com.example.clinicacelular;

import java.util.HashSet;

public class Service extends Item {


    protected String serviceTimeEstimate = "";

    /**
     *
     * @param itemName
     * @param Price
     * @param itemId
     * @param itemIcon
     * @param serviceTimeEstimate
     * @throws IllegalArgumentException
     */
    public Service(String itemName, double Price, String itemId, String itemIcon, String serviceTimeEstimate, String Category) throws IllegalArgumentException{
        super(itemName, Price, itemId, itemIcon, Category);
        if(serviceTimeEstimate == null || serviceTimeEstimate.length() == 0)
            throw new IllegalArgumentException("Customers need to see a predicted time it will take a service to be done(excluding wait time for the service).");
        this.serviceTimeEstimate = serviceTimeEstimate;
    }

    /**
     *
     * @param serviceTimeEstimate
     */
    public void setServiceTimeEstimate(String serviceTimeEstimate) {
        this.serviceTimeEstimate = serviceTimeEstimate;
    }

    /**
     *
     * @return serviceTimeEstimate
     */
    public String getServiceTimeEstimate() {
        return serviceTimeEstimate;
    }
}
