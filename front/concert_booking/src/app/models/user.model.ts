import { Booking } from "./booking.model";

export interface User {

  "@id": string,
  "@type": string,
  "id": number,
  "firstname": string,
  "lastname": string,
  "email": string,
  "password": string,
  "bookings": Booking[]
  
}