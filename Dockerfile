FROM nomadnt/lumen

ARG UID
ARG GID

RUN if [ ${UID:-0} -ne 0 ] && [ ${GID:-0} -ne 0 ]; then \
    deluser www-data \
    && addgroup -S -g ${GID} www-data \
	&& adduser -S -u ${UID} -s /bin/sh www-data \
	&& adduser www-data www-data \
;
