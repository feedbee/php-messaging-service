PHP Messaging Service
=====================

**PHP Messaging Service** is a OO-style PHP interface for **storage and communication software** (or services) that can be used to build messaging system (queues, databases, filesystem and so on). It designed to work with any type of storage and communication software as a backend and hides all technical system details behind the simplest sender and receiver interface. PHP Messaging Service doesn't limit power of different backend allowing to build powerful and flexible systems, but every backend must realize this minimal interface and operate with standard extendable messages.

**Message** is a data transfer unit that can be delivered by the system. Message (with it's metadata) can be passed in any format, including any custom formats. Message format can be chosen to be best readable in software tools, used to work with chosen backend. It it's not matter, choose default JSON format.

Message contains body data (of any type: numbers, string, array, Object, binary) and metadata key-value list (keys is PHP array keys types and value is any type like body data). Basically no any metadata passed with message, but this possibility realized to support extendability of library.

On two sides - sender and receiver - service must be configured to use the same (or compatible) **data adapters**. The aim of data adapter is to serialize message at sending time and unserialize it at receiving time. Default serializer is JSON. It requires all message data (body and metadata) to be json_encode()-able. If you have to pass objects it will be better to use PHP serializer, but don't forget to load the same classes on both sender and receiver sides.

Backend driver sends and receives data to/from storage and communication software. Usually, different data adapters can be used with different backends, but there can be exclusions. If backend requires data to be represented in some fixed format, so you have to set data adapter that will serialize message to this form. In other way you can choose the adapter you like more (but don't forget to use the same adapter on counterpart side).