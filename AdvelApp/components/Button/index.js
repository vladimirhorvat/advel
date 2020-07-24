/**
 * Sample React Native App
 * https://github.com/facebook/react-native
 *
 * @format
 * @flow strict-local
 */

import React from 'react';
import {
  SafeAreaView,
  StyleSheet,
  ScrollView,
  View,
  Text,
  StatusBar,
  TouchableOpacity,
} from 'react-native';

import {
  Header,
  LearnMoreLinks,
  Colors,
  DebugInstructions,
  ReloadInstructions,
} from 'react-native/Libraries/NewAppScreen';

import { useNavigation  } from '@react-navigation/native';

import styles from './styles';

const Button = (props: any)  => {
  
  const navigation = useNavigation(); 
  const handler = props.handler;

  const openLinkHandler = () => {
    if (props.navigate && props.navigate.url) {
      Linking.openURL(props.navigate.url);
    } else if (props.navigate) {
      navigation.navigate(props.navigate.screen, props.navigate.payload || {});
    }
  };

  const onPressMultipleHandler = () => {
    if (typeof props.handler !== 'undefined') {
      props.handler();
    } else {
      openLinkHandler();
    }
  };

  return (
    <View style={props.container}>
        <TouchableOpacity style={props.touch} onPress={() => onPressMultipleHandler()}>
            <Text style={props.textStyle}>{props.text}</Text>
        </TouchableOpacity>
    </View>
  );
};

export default Button;
