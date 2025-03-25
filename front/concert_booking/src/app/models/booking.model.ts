import { SeatType } from "./seat_type.model";
import { Session } from "./session.model";
import { User } from "./user.model";

export interface Booking  {

  "@id": string,
  "@type": string,
  "id": number,
  "booking_date": string,
  "seat_count": number,
  "user": User,
  "session": Session,
  "seat_type": SeatType,

}