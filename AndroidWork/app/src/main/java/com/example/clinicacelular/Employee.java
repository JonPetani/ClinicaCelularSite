/**
 * @author Jonathan Petani
 * @version 1
 */
package com.example.clinicacelular;

import android.os.Build;

import androidx.annotation.Nullable;
import androidx.annotation.RequiresApi;
import java.util.Comparator;
import java.util.PriorityQueue;

public class Employee {

    //Employee Types
    private static final String frontLine = "Front Line";
    private static final String Technician = "Specialized Technician";
    private static final String Software = "Software";
    private static final String Driver = "Pickup/Delivery";

    private String Name = "";
    private String phoneNum = "";
    private String emailAddress = "";
    private String Role = "";
    private boolean Available = false;
    private PriorityQueue<Customer> serviceTarget = new PriorityQueue<Customer>();
    private String employeeId = "";
    private StoreFront Store = null;

    public Employee(String Name, String Role, String employeeId, StoreFront Store) throws IllegalArgumentException{
        if(Name == null || Name.length() == 0)
            throw new IllegalArgumentException("All Employee's have a name.");
        if(Role == null || Role.length() == 0 || (Role.equals(frontLine) == false && Role.equals(Technician) == false && Role.equals(Software) == false && Role.equals(Driver) == false))
            throw new IllegalArgumentException("All Employee's Need A Role Specified by our Company (Front Line, Specialized Technician or Software).");
        if(employeeId == null || employeeId.length() == 0)
            throw new IllegalArgumentException("Employee ID is required for all Employees.");
        if(Store == null)
            throw new IllegalArgumentException("All Employee's Belong to a Store.");
        this.Name = Name;
        this.Role = Role;
        this.employeeId = employeeId;
        this.Store = Store;
    }

    public static Employee create(String Name, String phoneNum, String emailAddress, String Role, boolean Available, String employeeId, StoreFront Store) throws IllegalArgumentException{
        Employee e = new Employee(Name, Role, employeeId, Store);
        if((phoneNum == null || phoneNum.length() == 0) && (emailAddress == null || emailAddress.length() == 0))
            throw new IllegalArgumentException("A line of communication is needed for employees to the manager.");
        return e;
    }

    public void setName(String Name) {
        if(Name == null || Name.length() == 0)
            return;
        this.Name = Name;
    }

    public String getName() {
        return Name;
    }

    public void setPhoneNum(String phoneNum) {
        if(phoneNum == null || phoneNum.length() == 0)
            return;
        this.phoneNum = phoneNum;
    }

    public String getPhoneNum() {
        return  phoneNum;
    }

    public void setEmailAddress(String emailAddress) {
        if(emailAddress == null || emailAddress.length() == 0)
            return;
        this.emailAddress = emailAddress;
    }

    public String getEmailAddress() {
        return emailAddress;
    }

    public void setStore(StoreFront Store) {
        if(Store == null)
            return;
        this.Store = Store;
    }

    public StoreFront getStore() {
        return Store;
    }

    public void setAvailable(boolean Available) {
        this.Available = Available;
    }

    public boolean getAvailable() {
        return Available;
    }

    public void setEmployeeId() {
        employeeId = Store.idGenerator();
    }

    public String getEmployeeId() {
        return employeeId;
    }

    @RequiresApi(api = Build.VERSION_CODES.N)
    public void setTask(Customer c) {
        if(Available == false || c == null)
            return;
        switch(Role) {
            case frontLine:
            case Technician:
            case Software:
                if(Store.orderQueue.serviceQueue.contains(c) == false)
                    return;
                if()
                serviceTarget = c;
                break;
            case Driver:
                if(Store.orderQueue.pickupQueue.contains(c) == true || Store.orderQueue.deliveryQueue.contains(c) == true) {
                    serviceTarget = c;
                    break;
                }
                else
                    break;
            default:
                System.out.println("Error Notice: This Worker does not have a official company role. Should change this asap.");
                break;
        }
    }

    @Override
    public int hashCode() {
        return this.employeeId.hashCode();
    }

    @Override
    public boolean equals(Object o) {
        if(o == null || !(o instanceof Employee))
            return false;
        Employee e = (Employee) o;
        return this.employeeId == employeeId;
    }

}
