import { HallSeatType } from "./hall_seat_type.model";
import { Session } from "./session.model";

export interface Hall {

  "@id": string,
  "@type": string,
  "id": number,
  "name": string,
  "address": string,
  "capacity": number,
  "description": string,
  "sessions": Session[],
  "hallSeatTypes": HallSeatType[],
  "picture_path": string,

}

// export interface Hall {

//   "@id": string,
//   "@type": string,
//   "id": number,
//   "name": string,
//   "address": string,
//   "capacity": number,
//   "description": string,
//   "sessions": string[],
//   "hallSeatTypes": string[],
//   "picture_path": string,

// }