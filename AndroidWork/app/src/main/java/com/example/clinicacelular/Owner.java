/**
 * @author Jonathan Petani
 * @version 1
 */
package com.example.clinicacelular;

public class Owner {
    private String Name = "";
    private String emailAddress = "";
    private String phoneNumber = "";
    private String SID = "";

    /**
     *
     * @param Name
     * @param emailAddress
     * @param phoneNumber
     * @param SID
     * @throws IllegalArgumentException
     */
    public Owner(String Name, String emailAddress, String phoneNumber, String SID) throws IllegalArgumentException{
        if(Name == null || Name.length() == 0)
            throw new IllegalArgumentException("Owner of Company Needs Name.");
        if(emailAddress == null || emailAddress.length() == 0)
            throw new IllegalArgumentException("Email Contact is needed.");
        if(phoneNumber == null || phoneNumber.length() == 0)
            throw new IllegalArgumentException("Phone Contact is needed.");
        if(SID == null || SID.length() == 0)
            throw new IllegalArgumentException("SID must be present as the identifier for CEO for security reasons.");
        this.Name = Name;
        this.emailAddress = emailAddress;
        this.phoneNumber = phoneNumber;
        this.SID = SID;
    }

    /**
     *
     * @param Name
     */
    public void setName(String Name) {
        if(Name == null || Name.length() == 0)
            return;
        this.Name = Name;
    }

    /**
     *
     * @return Name
     */
    public String getName() {
        return Name;
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
     * @param SID
     */
    public void setSID(String SID) {
        if(SID == null || SID.length() == 0)
            return;
        this.SID = SID;
    }

    /**
     *
     * @return SID
     */
    public String getSID() {
        return SID;
    }

    /**
     *
     * @return hashCode
     */
    @Override
    public int hashCode() {
        return this.SID.hashCode();
    }

    /**
     *
     * @param o
     * @return Equality to Owner Data Type
     */
    @Override
    public boolean equals(Object o) {
        if(o == null || !(o instanceof Owner))
            return false;
        Owner ow = (Owner) o;
        return this.SID == SID;
    }

    /**
     *
     * @return Owner Field String
     */
    @Override
    public String toString() {
        StringBuilder ownerStr = new StringBuilder();
        ownerStr.append("| CEO Name: " + Name);
        ownerStr.append(", CEO Email: " + emailAddress);
        ownerStr.append(", CEO Phone Num: " + phoneNumber);
        ownerStr.append(", CEO SID Code: " + SID + "|");
        return ownerStr.toString();
    }
}
