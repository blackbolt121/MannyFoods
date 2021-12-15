import cv2 as cv
img = cv.imread("C:\\Users\\rgo19\\Pictures\\CQycrK9WsAAEQFR.jpg")
def rescaleFrame(frame, scale= 0.7):
    width = int (frame.shape[1]*scale)
    heigth = int(frame.shape[0]*scale)
    dimensions = (width,heigth)
    return cv.resize(frame, dimensions)
rescaleFrame(img,0.5)
cv.imshow("astronauta",img)
cv.waitKey(0)