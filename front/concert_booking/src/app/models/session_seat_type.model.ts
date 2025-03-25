import { SeatType } from "./seat_type.model";
import { Session } from "./session.model";

export interface SessionSeatType {

  "@id": string,
  "@type": string,
  "id": number,
  "price": number,
  "available_seats": number,
  "session": Session,
  "seat_type": SeatType,

}