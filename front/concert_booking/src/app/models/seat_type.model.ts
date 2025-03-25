import { HallSeatType } from "./hall_seat_type.model";
import { SessionSeatType } from "./session_seat_type.model";

export interface SeatType{

  "@id": string,
  "@type": string,
  "id": number,
  "name": string,
  "description": string,
  "sessionSeatTypes": SessionSeatType[],
  "hallSeatTypes": HallSeatType[],
}