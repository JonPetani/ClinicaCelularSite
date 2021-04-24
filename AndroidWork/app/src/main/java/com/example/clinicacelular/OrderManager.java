/**
 * @author Jonathan Petani
 * @version 1
 */
package com.example.clinicacelular;

import android.os.Build;
import androidx.annotation.RequiresApi;
import java.util.PriorityQueue;
import java.util.Comparator;
import java.util.ArrayList;


@RequiresApi(api = Build.VERSION_CODES.N)
public class OrderManager {
    private StoreFront Store = null;
    private String systemID = "";
    private Comparator<Customer> servicePriority = Comparator.comparing(Customer::getPriority).reversed();
    private PriorityQueue<Customer> pickupQueue = new PriorityQueue<Customer>(servicePriority);
    private PriorityQueue<Customer> serviceQueue = new PriorityQueue<Customer>(servicePriority);
    private PriorityQueue<Customer> deliveryQueue = new PriorityQueue<Customer>(servicePriority);
    private ArrayList<Customer> customerRecord = new ArrayList<Customer>();

    /**
     *
     * @param Store
     * @param systemID
     * @throws IllegalArgumentException
     */
    public OrderManager(StoreFront Store, String systemID) throws IllegalArgumentException{
        if(Store == null)
            throw new IllegalArgumentException("Each Service Manager Object Needs a Store to Operate it.");
        if(systemID == null || systemID.length() == 0)
            throw new IllegalArgumentException("A Security ID must exist for each Service Management System.");
        this.Store = Store;
        this.systemID = systemID;
    }

    /**
     *
     * @param sf
     */
    public void setStore(StoreFront sf) {
        this.Store = Store;
    }

    /**
     *
     * @return Store
     */
    public StoreFront getStore() {
        return Store;
    }

    /**
     *
     * @param systemID
     */
    public void setSystemID(String systemID) {
        this.systemID = systemID;
    }

    /**
     *
     * @return
     */
    public String getSystemID() {
        return systemID;
    }

    /**
     *
     * @param c
     */
    public void addToPickup(Customer c) {
        if(c == null || pickupQueue.contains(c) == true || serviceQueue.contains(c) == true || deliveryQueue.contains(c) == true || c.getPickupNeeded() == false)
            return;
        pickupQueue.add(c);
    }

    /**
     *
     * @param c
     */
    public void beginService(Customer c) {
        if(c == null || (pickupQueue.contains(c) == true && pickupQueue.peek() != c) || serviceQueue.contains(c) == true || serviceQueue.contains(c) == true)
            return;
        if(pickupQueue.peek() == c)
            serviceQueue.add(pickupQueue.poll());
        else
            serviceQueue.add(c);
    }

    /**
     *
     * @param c
     */
    public void beginDelivery(Customer c) {
        if(c == null || pickupQueue.contains(c) == true && (serviceQueue.contains(c) == true && serviceQueue.peek() != c) || deliveryQueue.contains(c) == true)
            return;
        if(serviceQueue.peek() == c)
            deliveryQueue.add(serviceQueue.poll());
        else
            serviceQueue.add(c);
    }

    /**
     *
     * @param c
     */
    public void endOrder(Customer c) {
        if(c == null || (deliveryQueue.contains(c) && deliveryQueue.peek() != c))
            return;
        customerRecord.add(deliveryQueue.poll());
    }

    /**
     *
     * @param c
     */
    public void removeCustomer(Customer c) {
        if(c == null)
            return;
        if (pickupQueue.contains(c) == true)
            pickupQueue.remove(c);
        else if(serviceQueue.contains(c) == true)
            serviceQueue.remove(c);
        else if(serviceQueue.contains(c) == true)
            deliveryQueue.remove(c);
        else
            System.out.println("Said customer does not exist in our order records.");
    }

    /**
     *
     * @return pickupQueue
     */
    public PriorityQueue<Customer> findPickups() {
        return pickupQueue;
    }

    /**
     *
     * @return serviceQueue
     */
    public PriorityQueue<Customer> findServiceJobs() {
        return serviceQueue;
    }

    /**
     *
     * @return deliveryQueue
     */
    public PriorityQueue<Customer> findDeliveries() {
        return deliveryQueue;
    }

    /**
     *
     * @return customerRecord
     */
    public ArrayList<Customer> findPastCustomerInfo() {
        return customerRecord;
    }

    /**
     *
     * @return hashCode
     */
    @Override
    public int hashCode() {
        return this.systemID.hashCode();
    }

    /**
     *
     * @param o
     * @return Equality to OrderManager Data Type
     */
    @Override
    public boolean equals(Object o) {
        if(o == null || !(o instanceof OrderManager))
            return false;
        OrderManager om = (OrderManager) o;
        return this.systemID == systemID;
    }

    /**
     *
     * @return Order Manager Field String
     */
    @Override
    public String toString() {
        StringBuilder orderStr = new StringBuilder();
        orderStr.append("| Store this Order System belongs to by Address: " + Store.getAddress());
        orderStr.append(", System ID for this Order System: " + systemID);
        if(pickupQueue.isEmpty() == false) {
            orderStr.append(", All Current Pickup Orders In Order To Serve(Name/Email/Phone): {");
            pickupQueue.forEach((Customer c) -> { orderStr.append(" [" + c.getCustomerName() + ":" + c.getEmailAddress() + ":" + c.getPhoneNumber() + "]");});
            orderStr.append("}");
        }
        if(serviceQueue.isEmpty() == false) {
            orderStr.append(", All Current Service Orders In Order To Serve(Name/Email/Phone): {");
            serviceQueue.forEach((Customer c) -> { orderStr.append(" [" + c.getCustomerName() + ":" + c.getEmailAddress() + ":" + c.getPhoneNumber() + "]");});
            orderStr.append("}");
        }
        if(deliveryQueue.isEmpty() == false) {
            orderStr.append(", All Current Delivery Orders In Order To Serve (Name/Email/Phone): {");
            deliveryQueue.forEach((Customer c) -> { orderStr.append(" [" + c.getCustomerName() + ":" + c.getEmailAddress() + ":" + c.getPhoneNumber() + "]");});
            orderStr.append("}");
        }
        return orderStr.toString();
    }
}
