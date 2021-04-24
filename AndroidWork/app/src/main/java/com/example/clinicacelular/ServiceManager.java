package com.example.clinicacelular;

import android.os.Build;
import androidx.annotation.RequiresApi;
import java.util.PriorityQueue;
import java.util.Comparator;
import java.util.HashMap;
import java.util.HashSet;

@RequiresApi(api = Build.VERSION_CODES.N)
public class ServiceManager {
    private StoreFront Store = null;
    private Comparator<Customer> servicePriority = Comparator.comparing(Customer::getPriority).reversed();
    private PriorityQueue<Customer> pickupQueue = new PriorityQueue<Customer>(servicePriority);
    private PriorityQueue<Customer> serviceQueue = new PriorityQueue<Customer>(servicePriority);
    private PriorityQueue<Customer> deliveryQueue = new PriorityQueue<Customer>(servicePriority);

    public ServiceManager(StoreFront Store) throws IllegalArgumentException{
        if(Store == null)
            throw new IllegalArgumentException("Each Service Manager Object Needs a Store to Operate it.");
        this.Store = Store;
    }

    public void setStore(StoreFront sf) {
        this.Store = Store;
    }

    public StoreFront getStore() {
        return Store;
    }

    public void addToPickup(Customer c) {
        if(c == null || pickupQueue.contains(c) == true || serviceQueue.contains(c) == true || deliveryQueue.contains(c) == true)
            return;
        pickupQueue.add(c);
    }

    public void beginService(Customer c) {
        if(c == null || pickupQueue.peek() != c || serviceQueue.contains(c) == true || serviceQueue.contains(c) == true)
            return;

    }
}
