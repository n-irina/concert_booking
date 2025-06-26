import { Booking } from "./booking.model";
import { Event_api } from "./event_api.model";
import { Hall } from "./hall.model";
import { SessionSeatType } from "./session_seat_type.model";

export interface Session {

  "@id": string,
  "@type": string,
  "id": number,
  "date_time": string,
  "event": Event_api,
  "hall": Hall,
  "hall_id"?: number,
  "bookings": Booking[],
  "sessionSeatTypes": SessionSeatType[],

}
