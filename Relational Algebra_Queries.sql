Relational Algebra Queries
1.	Retrieve all donors who prefer anonymity:
σ Preferences LIKE '%anonymity%' (Donor)

2.	Fetch all donations made using 'Credit Card':
σ PaymentMethod = 'Credit Card' (Donation)

3.	List all campaigns that end after June 2025:
σ EndDate > '2025-06-01' (Campaign)

4.	Show donor names and their contact info:
π Name, ContactInfo (Donor)

5.	List the names of all events with their corresponding dates:
π Name, Date (Event)

6.	Get all donations along with donor names:
Donation ⨝ Donation.DonorID = Donor.DonorID Donor

7.	Fetch all receipts with donation amounts and corresponding donors:
(Receipt ⨝ Receipt.DonationID = Donation.DonationID Donation) 
⨝ Donation.DonorID = Donor.DonorID Donor

8.	List all events along with the campaigns they belong to:
Event ⨝ Event.CampaignID = Campaign.CampaignID Campaign

9.	Find the total amount raised from all donations:
γ SUM(Amount) → TotalDonations (Donation)

10.	Count the number of donations made in January 2025:
γ COUNT(*) → JanuaryDonations (σ Date ≥ '2025-01-01' ∧ Date ≤ '2025-01-31' (Donation))

11.	Calculate the average donation amount:
γ AVG(Amount) → AverageDonation (Donation)

12.	Get the details of the highest donation:
Donation ⨝ Amount = MAX(Amount) (Donation)

13.	List donors who have donated more than $200:
π Name, ContactInfo (σ Amount > 200 (Donation ⨝ Donation.DonorID = Donor.DonorID))

14.	Find campaigns with no associated events:
Campaign − π CampaignID (Event)

15.	List all donors who prefer anonymity or focus on education:
π Name (σ Preferences LIKE '%anonymity%' (Donor)) ∪ 
π Name (σ Preferences LIKE '%education%' (Donor))

16.	Find donors who made donations but are not interested in medical campaigns:
π DonorID (Donation) − π DonorID (σ Preferences LIKE '%medical%' (Donor))

17.	Identify donors who contributed to more than one campaign:
γ DonorID, COUNT(CampaignID) → CampaignCount 
(Event ⨝ Event.CampaignID = Campaign.CampaignID ⨝ Campaign.CampaignID = Donation.DonationID)

18.	Find the difference between total campaign goals and funds raised:
γ CampaignID, Goal - FundsRaised → RemainingGoal (Campaign)

19.	List campaigns along with the number of events associated with them:
γ CampaignID, COUNT(EventID) → EventCount (Event)

20.	Find the most generous donor (by total donation amount):
γ DonorID, SUM(Amount) → TotalDonated (Donation) ⨝ Donor.DonorID 
σ TotalDonated = MAX(TotalDonated) (γ DonorID, SUM(Amount) → TotalDonated (Donation))