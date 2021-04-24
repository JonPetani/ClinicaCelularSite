/**
 * @version 1
 * @author Jonathan Petani
 */
package com.example.clinicacelular;
import androidx.annotation.Nullable;
import java.util.HashSet;

public class Customer {

//Priority Constants
private static final int premiumPriority = 3;
private static final int urgentCostPriority = 2;
private static final int regularPriority = 1;

private String customerName = "";
private String customerId = "";
private boolean Premium = false;
private boolean urgentCostPayed = false;
private String phoneNumber = "";
private String emailAddress = "";
private int Priority = 0;
private boolean pickupNeeded = false;
private HashSet<Object> itemList = new HashSet<>();
    /**
     *
     * @param customerName
     * @param customerId
     * @param Premium
     * @param urgentCostPayed
     * @throws IllegalArgumentException
     */
    public Customer(String customerName, String customerId, boolean Premium, boolean urgentCostPayed, HashSet<Object> itemList) throws IllegalArgumentException {
        if (customerName == null || customerName.length() == 0)
            throw new IllegalArgumentException("Customers Need To be Called By Something. Cannot Accept No Name.");
        if (customerId == null || customerId.length() == 0)
            throw new IllegalArgumentException("All customers must have a unique id code.");
        if (Premium != true && Premium != false)
            throw new IllegalArgumentException("A Customer is Premium or not. Cannot tell from input.");
        if (urgentCostPayed != true && urgentCostPayed != false)
            throw new IllegalArgumentException("A Customer payed the urgent cost or not. Cannot tell from input.");
        if(itemList == null || itemList.isEmpty() == true)
            throw new IllegalArgumentException("Customers must have at least one service or product to buy in order to be a customer.");
        this.customerName = customerName;
        this.customerId = customerId;
        this.Premium = Premium;
        this.urgentCostPayed = urgentCostPayed;
        this.itemList = itemList;
    }

    /**
     *
     * @param customerName
     * @param customerId
     * @param Premium
     * @param phoneNumber
     * @param emailAddress
     * @return A customer (Can be Premium or Regular)
     * @throws IllegalArgumentException
     */
    public static Customer create(String customerName, String customerId, boolean Premium, boolean urgentCostPayed, String phoneNumber, String emailAddress, boolean pickupNeeded, HashSet<Object> itemList) throws IllegalArgumentException {
        if((phoneNumber == null || phoneNumber.length() == 0) && (emailAddress == null || emailAddress.length() == 0)) {
            throw new IllegalArgumentException("No Form of Contact has been found.");
        }
        Customer c = new Customer(customerName, customerId, Premium, urgentCostPayed, itemList);
        c.setPhoneNumber(phoneNumber);
        c.setEmailAddress(emailAddress);
        if(Premium == true)
            c.setPriority(premiumPriority);
        else if(urgentCostPayed == true)
            c.setPriority(urgentCostPriority);
        else
            c.setPriority(regularPriority);
        return c;
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
     * @return emailAddress
     */
    public String getPhoneNumber() {
        return emailAddress;
    }

    /**
     *
     * @param emailAddress
     */
    public void setEmailAddress(String emailAddress) {
        if(emailAddress == null || emailAddress.length() == 0)
            return;
        this.emailAddress = emailAddress;
    }

    /**
     *
     * @return emailAddress
     */
    public String getEmailAddress() {
        return emailAddress;
    }

    /**
     * Sets Priority of Order for Customer (Effected by Premium vs Regular Customer)
     * @param Priority
     */
    public void setPriority(int Priority) {
        if(Priority < regularPriority && Priority > premiumPriority)
            return;
        this.Priority = Priority;
    }

    /**
     *
     * @return Priority
     */
    public int getPriority() {
        return Priority;
    }

    /**
     *
     * @param customerId
     */
    public void setCustomerId(String customerId) {
        if(customerId == null || customerId.length() == 0)
            return;
        this.customerId = customerId;
    }
    /**
     *
     * @return customerId
     */
    public String getCustomerId() {
        return customerId;
    }

    /**
     *
     * @param customerName
     */
    public void setCustomerName(String customerName) {
        if(customerName == null || customerName.length() == 0)
            return;
        this.customerName = customerName;
    }

    /**
     *
     * @return customerName
     */
    public String getCustomerName() {
        return customerName;
    }

    /**
     *
     * @param pickupNeeded
     */
    public void setPickupNeeded(boolean pickupNeeded) {
        this.pickupNeeded = pickupNeeded;
    }

    /**
     *
     * @return pickNeeded
     */
    public boolean getPickupNeeded() {
        return pickupNeeded;
    }

    /**
     *
     * @param itemList
     */
    public void setItemList(HashSet<Object> itemList) {
        if(itemList.isEmpty() == false)
            this.itemList.clear();
        this.itemList.addAll(itemList);
    }

    /**
     *
     * @return itemList
     */
    public HashSet<Object> getItemList() {
        return itemList;
    }

    /**
     *
     * @return hashcode
     */
    @Override
    public int hashCode() {
        return this.customerName.hashCode();
    }

    /**
     *
     * @param o
     * @return equality to Customer Data Type
     */
    @Override
    public boolean equals(Object o) {
        if(o == null || !(o instanceof Customer))
            return false;
        Customer c = (Customer) o;
    return this.customerId == customerId;
    }

    @Override
    /**
     * @return Customer Fields String
     */
    public String toString() {
        StringBuilder customerStr = new StringBuilder();
        customerStr.append("|Customer Name: " + customerName);
        if(phoneNumber == null || phoneNumber.length() == 0)
            customerStr.append(", Phone Number: None Provided");
        else
            customerStr.append(", Phone Number: " + phoneNumber);
        if(emailAddress == null || emailAddress.length() == 0)
            customerStr.append(", Email Address: None Provided");
        else
            customerStr.append(", Email Address: " + emailAddress);
        if(Premium == true)
            customerStr.append(", Premium Customer/Account: Yes");
        else
            customerStr.append(", Premium Customer/Account: No");
        if(urgentCostPayed == true)
            customerStr.append(", Payed Urgent Service Cost: Yes");
        else
            customerStr.append(", Payed Urgent Service Cost: No");
        if(Priority > regularPriority)
            customerStr.append(", Is this customer's service of higher priority? Order will be placed above others of lower priority");
        else
            customerStr.append(", Is this customer's service of higher priority? Order will remain in the regular first come first serve basic");
        customerStr.append(", Customer Id in System: " + customerId + "|");
        return customerStr.toString();
    }
}
