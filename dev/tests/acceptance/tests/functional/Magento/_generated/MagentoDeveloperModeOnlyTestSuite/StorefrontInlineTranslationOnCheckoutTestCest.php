<?php
namespace Magento\AcceptanceTest\_MagentoDeveloperModeOnlyTestSuite\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-26322: Inline translate on Checkout")
 * @Description("As merchant I want to be able to rename text labels on Checkout steps<h3>Test files</h3>app/code/Magento/Translation/Test/Mftf/Test/StorefrontInlineTranslationOnCheckoutTest.xml<br>")
 * @TestCaseId("MC-26322")
 * @group translation
 * @group checkout
 * @group developer_mode_only
 */
class StorefrontInlineTranslationOnCheckoutTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createCustomer
		$I->comment("Product and a customer is created");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Revert translate and changes");
		$enableTranslateInlineStorefront = $I->magentoCLI("config:set dev/translate_inline/active 1", 60); // stepKey: enableTranslateInlineStorefront
		$I->comment($enableTranslateInlineStorefront);
		$I->createEntity("revertProceedToCheckoutTranslate", "hook", "RevertProceedToCheckoutTranslate", ["createCustomer"], []); // stepKey: revertProceedToCheckoutTranslate
		$I->createEntity("revertViewAndEditCartTranslate", "hook", "RevertViewAndEditCartTranslate", ["createCustomer"], []); // stepKey: revertViewAndEditCartTranslate
		$I->createEntity("revertQtyTranslate", "hook", "RevertQtyTranslate", ["createCustomer"], []); // stepKey: revertQtyTranslate
		$I->createEntity("revertShippingAddressTitleTranslate", "hook", "RevertShippingAddressTitleTranslate", ["createCustomer"], []); // stepKey: revertShippingAddressTitleTranslate
		$I->createEntity("revertButtonShipHereTranslate", "hook", "RevertButtonShipHereTranslate", ["createCustomer"], []); // stepKey: revertButtonShipHereTranslate
		$I->createEntity("revertButtonNewAddressTranslate", "hook", "RevertButtonNewAddressTranslate", ["createCustomer"], []); // stepKey: revertButtonNewAddressTranslate
		$I->createEntity("revertShippingMethodTitleTranslate", "hook", "RevertShippingMethodTitleTranslate", ["createCustomer"], []); // stepKey: revertShippingMethodTitleTranslate
		$I->createEntity("revertButtonNextTranslate", "hook", "RevertButtonNextTranslate", ["createCustomer"], []); // stepKey: revertButtonNextTranslate
		$I->createEntity("revertOrderSummaryTitleTranslate", "hook", "RevertOrderSummaryTitleTranslate", ["createCustomer"], []); // stepKey: revertOrderSummaryTitleTranslate
		$I->createEntity("revertItemsInCartTextTranslate", "hook", "RevertItemsInCartTextTranslate", ["createCustomer"], []); // stepKey: revertItemsInCartTextTranslate
		$I->createEntity("revertProgressBarReviewAndPaymentsTranslate", "hook", "RevertProgressBarReviewAndPaymentsTranslate", ["createCustomer"], []); // stepKey: revertProgressBarReviewAndPaymentsTranslate
		$I->createEntity("revertPaymentTitleTranslate", "hook", "RevertPaymentTitleTranslate", ["createCustomer"], []); // stepKey: revertPaymentTitleTranslate
		$I->createEntity("revertCheckboxSameBillingAddressTranslate", "hook", "RevertCheckboxSameBillingAddressTranslate", ["createCustomer"], []); // stepKey: revertCheckboxSameBillingAddressTranslate
		$I->createEntity("revertButtonPlaceOrderTranslate", "hook", "RevertPlaceOrderButtonTranslate", ["createCustomer"], []); // stepKey: revertButtonPlaceOrderTranslate
		$I->createEntity("revertApplyDiscountCodeTranslate", "hook", "RevertApplyDiscountCodeTranslate", ["createCustomer"], []); // stepKey: revertApplyDiscountCodeTranslate
		$I->createEntity("revertCartSubtotalTextTranslate", "hook", "RevertCartSubtotalTextTranslate", ["createCustomer"], []); // stepKey: revertCartSubtotalTextTranslate
		$I->createEntity("revertShippingTextTranslate", "hook", "RevertShippingTextTranslate", ["createCustomer"], []); // stepKey: revertShippingTextTranslate
		$I->createEntity("revertOrderTotalTextTranslate", "hook", "RevertOrderTotalTextTranslate", ["createCustomer"], []); // stepKey: revertOrderTotalTextTranslate
		$I->createEntity("revertShipToTitleTranslate", "hook", "RevertShipToTitleTranslate", ["createCustomer"], []); // stepKey: revertShipToTitleTranslate
		$I->createEntity("revertShipViaTitleTranslate", "hook", "RevertShipViaTitleTranslate", ["createCustomer"], []); // stepKey: revertShipViaTitleTranslate
		$disableTranslateInlineForStorefront = $I->magentoCLI("config:set dev/translate_inline/active 0", 60); // stepKey: disableTranslateInlineForStorefront
		$I->comment($disableTranslateInlineForStorefront);
		$I->comment("Delete product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Logout customer from storefront and delete");
		$I->comment("Entering Action Group [signOutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutSignOutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutSignOutCustomer
		$I->comment("Exiting Action Group [signOutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Translation"})
	 * @Stories({"Inline Translation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontInlineTranslationOnCheckoutTest(AcceptanceTester $I)
	{
		$I->comment("Preconditions: Add product to cart on storefront");
		$I->comment("Entering Action Group [logInCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLogInCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLogInCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLogInCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLogInCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLogInCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLogInCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLogInCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLogInCustomer
		$I->comment("Exiting Action Group [logInCustomer] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart1] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCart1
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCart1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToCart1
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCart1
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart1
		$I->comment("Exiting Action Group [addProductToCart1] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("1. Enable Translate Inline For Storefront");
		$enableTranslateInlineForStorefront = $I->magentoCLI("config:set dev/translate_inline/active 1", 60); // stepKey: enableTranslateInlineForStorefront
		$I->comment($enableTranslateInlineForStorefront);
		$I->comment("2. Refresh magento cache");
		$I->comment("Entering Action Group [flushCacheAfterTranslateEnabled] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCacheAfterTranslateEnabled = $I->magentoCLI("cache:flush", 60, "translate full_page"); // stepKey: flushSpecifiedCacheFlushCacheAfterTranslateEnabled
		$I->comment($flushSpecifiedCacheFlushCacheAfterTranslateEnabled);
		$I->comment("Exiting Action Group [flushCacheAfterTranslateEnabled] CliCacheFlushActionGroup");
		$I->comment("3. Go to storefront and click on cart button on the top");
		$I->comment("Entering Action Group [reloadPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage
		$I->comment("Exiting Action Group [reloadPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->comment("Entering Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart
		$I->comment("Exiting Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->comment("Check button \"Proceed to Checkout\". There must be red borders and \"book\" icons on labels that can be translated.");
		$I->comment("Entering Action Group [assertProceedToCheckout] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertProceedToCheckout = $I->executeJS("return window.getComputedStyle(document.querySelector('#top-cart-btn-checkout')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: getBorderColorAssertProceedToCheckoutWaitForPageLoad
		$getBorderTypeAssertProceedToCheckout = $I->executeJS("return window.getComputedStyle(document.querySelector('#top-cart-btn-checkout')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: getBorderTypeAssertProceedToCheckoutWaitForPageLoad
		$getBorderWidthAssertProceedToCheckout = $I->executeJS("return window.getComputedStyle(document.querySelector('#top-cart-btn-checkout')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: getBorderWidthAssertProceedToCheckoutWaitForPageLoad
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertProceedToCheckout); // stepKey: assertBorderColorAssertProceedToCheckout
		$I->assertStringContainsString("dotted", $getBorderTypeAssertProceedToCheckout); // stepKey: assertBorderTypeAssertProceedToCheckout
		$I->assertStringContainsString("1px", $getBorderWidthAssertProceedToCheckout); // stepKey: assertBorderWidthAssertProceedToCheckout
		$I->comment("Exiting Action Group [assertProceedToCheckout] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateProceedToCheckout1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateProceedToCheckout1 = $I->executeJS("jQuery('#top-cart-btn-checkout').mousemove()"); // stepKey: moveMouseOverSelectorTranslateProceedToCheckout1
		$I->waitForPageLoad(30); // stepKey: moveMouseOverSelectorTranslateProceedToCheckout1WaitForPageLoad
		$clickBookIconTranslateProceedToCheckout1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateProceedToCheckout1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateProceedToCheckout1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateProceedToCheckout1
		$I->comment("Exiting Action Group [translateProceedToCheckout1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateProceedToCheckout2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateProceedToCheckout2
		$I->fillField("#translate-inline-form input.input-text", "Proceed to Checkout Translated"); // stepKey: fillCustomTranslateFieldTranslateProceedToCheckout2
		$I->comment("Exiting Action Group [translateProceedToCheckout2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateProceedToCheckout3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateProceedToCheckout3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateProceedToCheckout3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateProceedToCheckout3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateProceedToCheckout3
		$I->comment("Exiting Action Group [translateProceedToCheckout3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check button \"View and Edit Cart\". There must be red borders and \"book\" icons on labels that can be translated.");
		$I->comment("Entering Action Group [assertViewAndEditCart] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertViewAndEditCart = $I->executeJS("return window.getComputedStyle(document.querySelector('.action.viewcart span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertViewAndEditCart
		$getBorderTypeAssertViewAndEditCart = $I->executeJS("return window.getComputedStyle(document.querySelector('.action.viewcart span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertViewAndEditCart
		$getBorderWidthAssertViewAndEditCart = $I->executeJS("return window.getComputedStyle(document.querySelector('.action.viewcart span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertViewAndEditCart
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertViewAndEditCart); // stepKey: assertBorderColorAssertViewAndEditCart
		$I->assertStringContainsString("dotted", $getBorderTypeAssertViewAndEditCart); // stepKey: assertBorderTypeAssertViewAndEditCart
		$I->assertStringContainsString("1px", $getBorderWidthAssertViewAndEditCart); // stepKey: assertBorderWidthAssertViewAndEditCart
		$I->comment("Exiting Action Group [assertViewAndEditCart] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateViewAndEditCart1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateViewAndEditCart1 = $I->executeJS("jQuery('.action.viewcart span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateViewAndEditCart1
		$clickBookIconTranslateViewAndEditCart1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateViewAndEditCart1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateViewAndEditCart1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateViewAndEditCart1
		$I->comment("Exiting Action Group [translateViewAndEditCart1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateViewAndEditCart2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateViewAndEditCart2
		$I->fillField("#translate-inline-form input.input-text", "Edit Cart Translated"); // stepKey: fillCustomTranslateFieldTranslateViewAndEditCart2
		$I->comment("Exiting Action Group [translateViewAndEditCart2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateViewAndEditCart3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateViewAndEditCart3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateViewAndEditCart3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateViewAndEditCart3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateViewAndEditCart3
		$I->comment("Exiting Action Group [translateViewAndEditCart3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("4. Click on \"book\" icon near the all red bordered labels one by one. And change translation for these labels.");
		$I->comment("Check \"Item in Cart\"");
		$I->comment("Entering Action Group [assertVisibleItemsCountText] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertVisibleItemsCountText = $I->executeJS("return window.getComputedStyle(document.querySelector('.items-total > span:nth-of-type(2)')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertVisibleItemsCountText
		$getBorderTypeAssertVisibleItemsCountText = $I->executeJS("return window.getComputedStyle(document.querySelector('.items-total > span:nth-of-type(2)')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertVisibleItemsCountText
		$getBorderWidthAssertVisibleItemsCountText = $I->executeJS("return window.getComputedStyle(document.querySelector('.items-total > span:nth-of-type(2)')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertVisibleItemsCountText
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertVisibleItemsCountText); // stepKey: assertBorderColorAssertVisibleItemsCountText
		$I->assertStringContainsString("dotted", $getBorderTypeAssertVisibleItemsCountText); // stepKey: assertBorderTypeAssertVisibleItemsCountText
		$I->assertStringContainsString("1px", $getBorderWidthAssertVisibleItemsCountText); // stepKey: assertBorderWidthAssertVisibleItemsCountText
		$I->comment("Exiting Action Group [assertVisibleItemsCountText] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateVisibleItemsCountText1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateVisibleItemsCountText1 = $I->executeJS("jQuery('.items-total > span:nth-of-type(2)').mousemove()"); // stepKey: moveMouseOverSelectorTranslateVisibleItemsCountText1
		$clickBookIconTranslateVisibleItemsCountText1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateVisibleItemsCountText1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateVisibleItemsCountText1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateVisibleItemsCountText1
		$I->comment("Exiting Action Group [translateVisibleItemsCountText1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateVisibleItemsCountText2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateVisibleItemsCountText2
		$I->fillField("#translate-inline-form input.input-text", "Item in Cart Translated"); // stepKey: fillCustomTranslateFieldTranslateVisibleItemsCountText2
		$I->comment("Exiting Action Group [translateVisibleItemsCountText2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateVisibleItemsCountText3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateVisibleItemsCountText3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateVisibleItemsCountText3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateVisibleItemsCountText3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateVisibleItemsCountText3
		$I->comment("Exiting Action Group [translateVisibleItemsCountText3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check \"Cart Subtotal\"");
		$I->comment("Entering Action Group [assertCartSubtotal] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertCartSubtotal = $I->executeJS("return window.getComputedStyle(document.querySelector('.subtotal .label span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertCartSubtotal
		$getBorderTypeAssertCartSubtotal = $I->executeJS("return window.getComputedStyle(document.querySelector('.subtotal .label span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertCartSubtotal
		$getBorderWidthAssertCartSubtotal = $I->executeJS("return window.getComputedStyle(document.querySelector('.subtotal .label span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertCartSubtotal
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertCartSubtotal); // stepKey: assertBorderColorAssertCartSubtotal
		$I->assertStringContainsString("dotted", $getBorderTypeAssertCartSubtotal); // stepKey: assertBorderTypeAssertCartSubtotal
		$I->assertStringContainsString("1px", $getBorderWidthAssertCartSubtotal); // stepKey: assertBorderWidthAssertCartSubtotal
		$I->comment("Exiting Action Group [assertCartSubtotal] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateCartSubtotal1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateCartSubtotal1 = $I->executeJS("jQuery('.subtotal .label span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateCartSubtotal1
		$clickBookIconTranslateCartSubtotal1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateCartSubtotal1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateCartSubtotal1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateCartSubtotal1
		$I->comment("Exiting Action Group [translateCartSubtotal1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateCartSubtotal2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateCartSubtotal2
		$I->fillField("#translate-inline-form input.input-text", "Cart Subtotal Translated"); // stepKey: fillCustomTranslateFieldTranslateCartSubtotal2
		$I->comment("Exiting Action Group [translateCartSubtotal2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateCartSubtotal3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateCartSubtotal3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateCartSubtotal3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateCartSubtotal3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateCartSubtotal3
		$I->comment("Exiting Action Group [translateCartSubtotal3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check label \"Qty\"");
		$I->comment("Entering Action Group [assertQty] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertQty = $I->executeJS("return window.getComputedStyle(document.querySelector('.details-qty label')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertQty
		$getBorderTypeAssertQty = $I->executeJS("return window.getComputedStyle(document.querySelector('.details-qty label')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertQty
		$getBorderWidthAssertQty = $I->executeJS("return window.getComputedStyle(document.querySelector('.details-qty label')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertQty
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertQty); // stepKey: assertBorderColorAssertQty
		$I->assertStringContainsString("dotted", $getBorderTypeAssertQty); // stepKey: assertBorderTypeAssertQty
		$I->assertStringContainsString("1px", $getBorderWidthAssertQty); // stepKey: assertBorderWidthAssertQty
		$I->comment("Exiting Action Group [assertQty] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateQty1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateQty1 = $I->executeJS("jQuery('.details-qty label').mousemove()"); // stepKey: moveMouseOverSelectorTranslateQty1
		$clickBookIconTranslateQty1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateQty1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateQty1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateQty1
		$I->comment("Exiting Action Group [translateQty1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateQty2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateQty2
		$I->fillField("#translate-inline-form input.input-text", "Qty Translated"); // stepKey: fillCustomTranslateFieldTranslateQty2
		$I->comment("Exiting Action Group [translateQty2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateQty3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateQty3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateQty3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateQty3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateQty3
		$I->comment("Exiting Action Group [translateQty3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("5. Go to checkout page");
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutLoad
		$I->comment("6. Go through checkout process and try to translate all labels that have red border with 'book' icon.  Like you did it in step #4.");
		$I->comment("Check Progress Bar Shipping");
		$I->comment("Entering Action Group [assertProgressBarShipping] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertProgressBarShipping = $I->executeJS("return window.getComputedStyle(document.querySelector('.opc-progress-bar ._active span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertProgressBarShipping
		$getBorderTypeAssertProgressBarShipping = $I->executeJS("return window.getComputedStyle(document.querySelector('.opc-progress-bar ._active span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertProgressBarShipping
		$getBorderWidthAssertProgressBarShipping = $I->executeJS("return window.getComputedStyle(document.querySelector('.opc-progress-bar ._active span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertProgressBarShipping
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertProgressBarShipping); // stepKey: assertBorderColorAssertProgressBarShipping
		$I->assertStringContainsString("dotted", $getBorderTypeAssertProgressBarShipping); // stepKey: assertBorderTypeAssertProgressBarShipping
		$I->assertStringContainsString("1px", $getBorderWidthAssertProgressBarShipping); // stepKey: assertBorderWidthAssertProgressBarShipping
		$I->comment("Exiting Action Group [assertProgressBarShipping] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateProgressBarShipping1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateProgressBarShipping1 = $I->executeJS("jQuery('.opc-progress-bar ._active span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateProgressBarShipping1
		$clickBookIconTranslateProgressBarShipping1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateProgressBarShipping1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateProgressBarShipping1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateProgressBarShipping1
		$I->comment("Exiting Action Group [translateProgressBarShipping1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateProgressBarShipping2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateProgressBarShipping2
		$I->fillField("#translate-inline-form input.input-text", "Shipping Translated"); // stepKey: fillCustomTranslateFieldTranslateProgressBarShipping2
		$I->comment("Exiting Action Group [translateProgressBarShipping2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateProgressBarShipping3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateProgressBarShipping3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateProgressBarShipping3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateProgressBarShipping3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateProgressBarShipping3
		$I->comment("Exiting Action Group [translateProgressBarShipping3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check step title \"Shipping Address\"");
		$I->comment("Entering Action Group [assertShippingAddressTitle] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertShippingAddressTitle = $I->executeJS("return window.getComputedStyle(document.querySelector('#shipping div.step-title')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertShippingAddressTitle
		$getBorderTypeAssertShippingAddressTitle = $I->executeJS("return window.getComputedStyle(document.querySelector('#shipping div.step-title')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertShippingAddressTitle
		$getBorderWidthAssertShippingAddressTitle = $I->executeJS("return window.getComputedStyle(document.querySelector('#shipping div.step-title')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertShippingAddressTitle
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertShippingAddressTitle); // stepKey: assertBorderColorAssertShippingAddressTitle
		$I->assertStringContainsString("dotted", $getBorderTypeAssertShippingAddressTitle); // stepKey: assertBorderTypeAssertShippingAddressTitle
		$I->assertStringContainsString("1px", $getBorderWidthAssertShippingAddressTitle); // stepKey: assertBorderWidthAssertShippingAddressTitle
		$I->comment("Exiting Action Group [assertShippingAddressTitle] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateShippingAddressTitle1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateShippingAddressTitle1 = $I->executeJS("jQuery('#shipping div.step-title').mousemove()"); // stepKey: moveMouseOverSelectorTranslateShippingAddressTitle1
		$clickBookIconTranslateShippingAddressTitle1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateShippingAddressTitle1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateShippingAddressTitle1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateShippingAddressTitle1
		$I->comment("Exiting Action Group [translateShippingAddressTitle1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateShippingAddressTitle2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateShippingAddressTitle2
		$I->fillField("#translate-inline-form input.input-text", "Shipping address Translated"); // stepKey: fillCustomTranslateFieldTranslateShippingAddressTitle2
		$I->comment("Exiting Action Group [translateShippingAddressTitle2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateShippingAddressTitle3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateShippingAddressTitle3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateShippingAddressTitle3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateShippingAddressTitle3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateShippingAddressTitle3
		$I->comment("Exiting Action Group [translateShippingAddressTitle3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check button \"Ship Here\"");
		$I->comment("Entering Action Group [assertButtonShipHere] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertButtonShipHere = $I->executeJS("return window.getComputedStyle(document.querySelector('button.action-select-shipping-item span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertButtonShipHere
		$getBorderTypeAssertButtonShipHere = $I->executeJS("return window.getComputedStyle(document.querySelector('button.action-select-shipping-item span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertButtonShipHere
		$getBorderWidthAssertButtonShipHere = $I->executeJS("return window.getComputedStyle(document.querySelector('button.action-select-shipping-item span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertButtonShipHere
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertButtonShipHere); // stepKey: assertBorderColorAssertButtonShipHere
		$I->assertStringContainsString("dotted", $getBorderTypeAssertButtonShipHere); // stepKey: assertBorderTypeAssertButtonShipHere
		$I->assertStringContainsString("1px", $getBorderWidthAssertButtonShipHere); // stepKey: assertBorderWidthAssertButtonShipHere
		$I->comment("Exiting Action Group [assertButtonShipHere] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateButtonShipHere1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateButtonShipHere1 = $I->executeJS("jQuery('button.action-select-shipping-item span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateButtonShipHere1
		$clickBookIconTranslateButtonShipHere1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateButtonShipHere1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateButtonShipHere1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateButtonShipHere1
		$I->comment("Exiting Action Group [translateButtonShipHere1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateButtonShipHere2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateButtonShipHere2
		$I->fillField("#translate-inline-form input.input-text", "Ship Here Translated"); // stepKey: fillCustomTranslateFieldTranslateButtonShipHere2
		$I->comment("Exiting Action Group [translateButtonShipHere2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateButtonShipHere3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateButtonShipHere3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateButtonShipHere3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateButtonShipHere3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateButtonShipHere3
		$I->comment("Exiting Action Group [translateButtonShipHere3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check button \"+ New Address\"");
		$I->comment("Entering Action Group [assertButtonNewAddress] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertButtonNewAddress = $I->executeJS("return window.getComputedStyle(document.querySelector('.new-address-popup button span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertButtonNewAddress
		$getBorderTypeAssertButtonNewAddress = $I->executeJS("return window.getComputedStyle(document.querySelector('.new-address-popup button span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertButtonNewAddress
		$getBorderWidthAssertButtonNewAddress = $I->executeJS("return window.getComputedStyle(document.querySelector('.new-address-popup button span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertButtonNewAddress
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertButtonNewAddress); // stepKey: assertBorderColorAssertButtonNewAddress
		$I->assertStringContainsString("dotted", $getBorderTypeAssertButtonNewAddress); // stepKey: assertBorderTypeAssertButtonNewAddress
		$I->assertStringContainsString("1px", $getBorderWidthAssertButtonNewAddress); // stepKey: assertBorderWidthAssertButtonNewAddress
		$I->comment("Exiting Action Group [assertButtonNewAddress] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateButtonNewAddress1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateButtonNewAddress1 = $I->executeJS("jQuery('.new-address-popup button span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateButtonNewAddress1
		$clickBookIconTranslateButtonNewAddress1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateButtonNewAddress1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateButtonNewAddress1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateButtonNewAddress1
		$I->comment("Exiting Action Group [translateButtonNewAddress1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateButtonNewAddress2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateButtonNewAddress2
		$I->fillField("#translate-inline-form input.input-text", "New Address Translated"); // stepKey: fillCustomTranslateFieldTranslateButtonNewAddress2
		$I->comment("Exiting Action Group [translateButtonNewAddress2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateButtonNewAddress3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateButtonNewAddress3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateButtonNewAddress3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateButtonNewAddress3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateButtonNewAddress3
		$I->comment("Exiting Action Group [translateButtonNewAddress3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check title \"Shipping Method\"");
		$I->comment("Entering Action Group [assertTitleShippingMethod] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertTitleShippingMethod = $I->executeJS("return window.getComputedStyle(document.querySelector('.checkout-shipping-method .step-title')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertTitleShippingMethod
		$getBorderTypeAssertTitleShippingMethod = $I->executeJS("return window.getComputedStyle(document.querySelector('.checkout-shipping-method .step-title')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertTitleShippingMethod
		$getBorderWidthAssertTitleShippingMethod = $I->executeJS("return window.getComputedStyle(document.querySelector('.checkout-shipping-method .step-title')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertTitleShippingMethod
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertTitleShippingMethod); // stepKey: assertBorderColorAssertTitleShippingMethod
		$I->assertStringContainsString("dotted", $getBorderTypeAssertTitleShippingMethod); // stepKey: assertBorderTypeAssertTitleShippingMethod
		$I->assertStringContainsString("1px", $getBorderWidthAssertTitleShippingMethod); // stepKey: assertBorderWidthAssertTitleShippingMethod
		$I->comment("Exiting Action Group [assertTitleShippingMethod] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateTitleShippingMethod1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateTitleShippingMethod1 = $I->executeJS("jQuery('.checkout-shipping-method .step-title').mousemove()"); // stepKey: moveMouseOverSelectorTranslateTitleShippingMethod1
		$clickBookIconTranslateTitleShippingMethod1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateTitleShippingMethod1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateTitleShippingMethod1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateTitleShippingMethod1
		$I->comment("Exiting Action Group [translateTitleShippingMethod1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateTitleShippingMethod2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateTitleShippingMethod2
		$I->fillField("#translate-inline-form input.input-text", "Shipping Methods Translated"); // stepKey: fillCustomTranslateFieldTranslateTitleShippingMethod2
		$I->comment("Exiting Action Group [translateTitleShippingMethod2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateTitleShippingMethod3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateTitleShippingMethod3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateTitleShippingMethod3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateTitleShippingMethod3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateTitleShippingMethod3
		$I->comment("Exiting Action Group [translateTitleShippingMethod3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check button \"Next\"");
		$I->comment("Entering Action Group [assertButtonNext] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertButtonNext = $I->executeJS("return window.getComputedStyle(document.querySelector('#shipping-method-buttons-container button.primary span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertButtonNext
		$getBorderTypeAssertButtonNext = $I->executeJS("return window.getComputedStyle(document.querySelector('#shipping-method-buttons-container button.primary span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertButtonNext
		$getBorderWidthAssertButtonNext = $I->executeJS("return window.getComputedStyle(document.querySelector('#shipping-method-buttons-container button.primary span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertButtonNext
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertButtonNext); // stepKey: assertBorderColorAssertButtonNext
		$I->assertStringContainsString("dotted", $getBorderTypeAssertButtonNext); // stepKey: assertBorderTypeAssertButtonNext
		$I->assertStringContainsString("1px", $getBorderWidthAssertButtonNext); // stepKey: assertBorderWidthAssertButtonNext
		$I->comment("Exiting Action Group [assertButtonNext] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateButtonNext1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateButtonNext1 = $I->executeJS("jQuery('#shipping-method-buttons-container button.primary span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateButtonNext1
		$clickBookIconTranslateButtonNext1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateButtonNext1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateButtonNext1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateButtonNext1
		$I->comment("Exiting Action Group [translateButtonNext1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateButtonNext2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateButtonNext2
		$I->fillField("#translate-inline-form input.input-text", "Next Translated"); // stepKey: fillCustomTranslateFieldTranslateButtonNext2
		$I->comment("Exiting Action Group [translateButtonNext2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateButtonNext3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateButtonNext3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateButtonNext3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateButtonNext3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateButtonNext3
		$I->comment("Exiting Action Group [translateButtonNext3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check title \"Order Summary\"");
		$I->comment("Entering Action Group [assertTitleOrderSummary] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertTitleOrderSummary = $I->executeJS("return window.getComputedStyle(document.querySelector('.opc-block-summary span.title')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertTitleOrderSummary
		$getBorderTypeAssertTitleOrderSummary = $I->executeJS("return window.getComputedStyle(document.querySelector('.opc-block-summary span.title')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertTitleOrderSummary
		$getBorderWidthAssertTitleOrderSummary = $I->executeJS("return window.getComputedStyle(document.querySelector('.opc-block-summary span.title')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertTitleOrderSummary
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertTitleOrderSummary); // stepKey: assertBorderColorAssertTitleOrderSummary
		$I->assertStringContainsString("dotted", $getBorderTypeAssertTitleOrderSummary); // stepKey: assertBorderTypeAssertTitleOrderSummary
		$I->assertStringContainsString("1px", $getBorderWidthAssertTitleOrderSummary); // stepKey: assertBorderWidthAssertTitleOrderSummary
		$I->comment("Exiting Action Group [assertTitleOrderSummary] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateTitleOrderSummary1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateTitleOrderSummary1 = $I->executeJS("jQuery('.opc-block-summary span.title').mousemove()"); // stepKey: moveMouseOverSelectorTranslateTitleOrderSummary1
		$clickBookIconTranslateTitleOrderSummary1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateTitleOrderSummary1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateTitleOrderSummary1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateTitleOrderSummary1
		$I->comment("Exiting Action Group [translateTitleOrderSummary1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateTitleOrderSummary2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateTitleOrderSummary2
		$I->fillField("#translate-inline-form input.input-text", "Order Summary Translated"); // stepKey: fillCustomTranslateFieldTranslateTitleOrderSummary2
		$I->comment("Exiting Action Group [translateTitleOrderSummary2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateTitleOrderSummary3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateTitleOrderSummary3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateTitleOrderSummary3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateTitleOrderSummary3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateTitleOrderSummary3
		$I->comment("Exiting Action Group [translateTitleOrderSummary3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check text \"Item in Cart\"");
		$I->comment("Entering Action Group [assertItemsInCartText] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertItemsInCartText = $I->executeJS("return window.getComputedStyle(document.querySelector('.items-in-cart strong span:nth-of-type(2)')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertItemsInCartText
		$getBorderTypeAssertItemsInCartText = $I->executeJS("return window.getComputedStyle(document.querySelector('.items-in-cart strong span:nth-of-type(2)')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertItemsInCartText
		$getBorderWidthAssertItemsInCartText = $I->executeJS("return window.getComputedStyle(document.querySelector('.items-in-cart strong span:nth-of-type(2)')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertItemsInCartText
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertItemsInCartText); // stepKey: assertBorderColorAssertItemsInCartText
		$I->assertStringContainsString("dotted", $getBorderTypeAssertItemsInCartText); // stepKey: assertBorderTypeAssertItemsInCartText
		$I->assertStringContainsString("1px", $getBorderWidthAssertItemsInCartText); // stepKey: assertBorderWidthAssertItemsInCartText
		$I->comment("Exiting Action Group [assertItemsInCartText] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateItemsInCartText1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateItemsInCartText1 = $I->executeJS("jQuery('.items-in-cart strong span:nth-of-type(2)').mousemove()"); // stepKey: moveMouseOverSelectorTranslateItemsInCartText1
		$clickBookIconTranslateItemsInCartText1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateItemsInCartText1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateItemsInCartText1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateItemsInCartText1
		$I->comment("Exiting Action Group [translateItemsInCartText1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateItemsInCartText2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateItemsInCartText2
		$I->fillField("#translate-inline-form input.input-text", "Item in Cart Translated"); // stepKey: fillCustomTranslateFieldTranslateItemsInCartText2
		$I->comment("Exiting Action Group [translateItemsInCartText2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateItemsInCartText3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateItemsInCartText3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateItemsInCartText3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateItemsInCartText3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateItemsInCartText3
		$I->comment("Exiting Action Group [translateItemsInCartText3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Go to next step");
		$I->comment("Entering Action Group [selectFlatRateShippingMethodBeforeTranslate] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRateShippingMethodBeforeTranslate
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShippingMethodBeforeTranslate
		$I->comment("Exiting Action Group [selectFlatRateShippingMethodBeforeTranslate] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [gotoPaymentStepBeforeTranslate] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGotoPaymentStepBeforeTranslate
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGotoPaymentStepBeforeTranslateWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGotoPaymentStepBeforeTranslate
		$I->waitForPageLoad(30); // stepKey: clickNextGotoPaymentStepBeforeTranslateWaitForPageLoad
		$I->comment("Exiting Action Group [gotoPaymentStepBeforeTranslate] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->comment("Check Progress Bar Review & Payments");
		$I->comment("Entering Action Group [assertProgressBarReviewAndPayments] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertProgressBarReviewAndPayments = $I->executeJS("return window.getComputedStyle(document.querySelector('.opc-progress-bar ._active span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertProgressBarReviewAndPayments
		$getBorderTypeAssertProgressBarReviewAndPayments = $I->executeJS("return window.getComputedStyle(document.querySelector('.opc-progress-bar ._active span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertProgressBarReviewAndPayments
		$getBorderWidthAssertProgressBarReviewAndPayments = $I->executeJS("return window.getComputedStyle(document.querySelector('.opc-progress-bar ._active span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertProgressBarReviewAndPayments
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertProgressBarReviewAndPayments); // stepKey: assertBorderColorAssertProgressBarReviewAndPayments
		$I->assertStringContainsString("dotted", $getBorderTypeAssertProgressBarReviewAndPayments); // stepKey: assertBorderTypeAssertProgressBarReviewAndPayments
		$I->assertStringContainsString("1px", $getBorderWidthAssertProgressBarReviewAndPayments); // stepKey: assertBorderWidthAssertProgressBarReviewAndPayments
		$I->comment("Exiting Action Group [assertProgressBarReviewAndPayments] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateProgressBarReviewAndPayments1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateProgressBarReviewAndPayments1 = $I->executeJS("jQuery('.opc-progress-bar ._active span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateProgressBarReviewAndPayments1
		$clickBookIconTranslateProgressBarReviewAndPayments1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateProgressBarReviewAndPayments1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateProgressBarReviewAndPayments1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateProgressBarReviewAndPayments1
		$I->comment("Exiting Action Group [translateProgressBarReviewAndPayments1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateProgressBarReviewAndPayments2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateProgressBarReviewAndPayments2
		$I->fillField("#translate-inline-form input.input-text", "Review & Payments Translated"); // stepKey: fillCustomTranslateFieldTranslateProgressBarReviewAndPayments2
		$I->comment("Exiting Action Group [translateProgressBarReviewAndPayments2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateProgressBarReviewAndPayments3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateProgressBarReviewAndPayments3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateProgressBarReviewAndPayments3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateProgressBarReviewAndPayments3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateProgressBarReviewAndPayments3
		$I->comment("Exiting Action Group [translateProgressBarReviewAndPayments3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check title \"Payment Method\"");
		$I->comment("Entering Action Group [assertTitlePayment] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertTitlePayment = $I->executeJS("return window.getComputedStyle(document.querySelector('.payment-group .step-title')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertTitlePayment
		$getBorderTypeAssertTitlePayment = $I->executeJS("return window.getComputedStyle(document.querySelector('.payment-group .step-title')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertTitlePayment
		$getBorderWidthAssertTitlePayment = $I->executeJS("return window.getComputedStyle(document.querySelector('.payment-group .step-title')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertTitlePayment
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertTitlePayment); // stepKey: assertBorderColorAssertTitlePayment
		$I->assertStringContainsString("dotted", $getBorderTypeAssertTitlePayment); // stepKey: assertBorderTypeAssertTitlePayment
		$I->assertStringContainsString("1px", $getBorderWidthAssertTitlePayment); // stepKey: assertBorderWidthAssertTitlePayment
		$I->comment("Exiting Action Group [assertTitlePayment] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateTitlePayment1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateTitlePayment1 = $I->executeJS("jQuery('.payment-group .step-title').mousemove()"); // stepKey: moveMouseOverSelectorTranslateTitlePayment1
		$clickBookIconTranslateTitlePayment1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateTitlePayment1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateTitlePayment1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateTitlePayment1
		$I->comment("Exiting Action Group [translateTitlePayment1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateTitlePayment2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateTitlePayment2
		$I->fillField("#translate-inline-form input.input-text", "Payment Method Translated"); // stepKey: fillCustomTranslateFieldTranslateTitlePayment2
		$I->comment("Exiting Action Group [translateTitlePayment2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateTitlePayment3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateTitlePayment3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateTitlePayment3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateTitlePayment3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateTitlePayment3
		$I->comment("Exiting Action Group [translateTitlePayment3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check text for checkbox \"My billing and shipping address are the same\"");
		$I->comment("Entering Action Group [assertCheckboxSameBillingAddress] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertCheckboxSameBillingAddress = $I->executeJS("return window.getComputedStyle(document.querySelector('.billing-address-same-as-shipping-block span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertCheckboxSameBillingAddress
		$getBorderTypeAssertCheckboxSameBillingAddress = $I->executeJS("return window.getComputedStyle(document.querySelector('.billing-address-same-as-shipping-block span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertCheckboxSameBillingAddress
		$getBorderWidthAssertCheckboxSameBillingAddress = $I->executeJS("return window.getComputedStyle(document.querySelector('.billing-address-same-as-shipping-block span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertCheckboxSameBillingAddress
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertCheckboxSameBillingAddress); // stepKey: assertBorderColorAssertCheckboxSameBillingAddress
		$I->assertStringContainsString("dotted", $getBorderTypeAssertCheckboxSameBillingAddress); // stepKey: assertBorderTypeAssertCheckboxSameBillingAddress
		$I->assertStringContainsString("1px", $getBorderWidthAssertCheckboxSameBillingAddress); // stepKey: assertBorderWidthAssertCheckboxSameBillingAddress
		$I->comment("Exiting Action Group [assertCheckboxSameBillingAddress] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateCheckboxSameBillingAddress1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateCheckboxSameBillingAddress1 = $I->executeJS("jQuery('.billing-address-same-as-shipping-block span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateCheckboxSameBillingAddress1
		$clickBookIconTranslateCheckboxSameBillingAddress1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateCheckboxSameBillingAddress1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateCheckboxSameBillingAddress1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateCheckboxSameBillingAddress1
		$I->comment("Exiting Action Group [translateCheckboxSameBillingAddress1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateCheckboxSameBillingAddress2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateCheckboxSameBillingAddress2
		$I->fillField("#translate-inline-form input.input-text", "My billing and shipping address are the same Translated"); // stepKey: fillCustomTranslateFieldTranslateCheckboxSameBillingAddress2
		$I->comment("Exiting Action Group [translateCheckboxSameBillingAddress2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateCheckboxSameBillingAddress3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateCheckboxSameBillingAddress3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateCheckboxSameBillingAddress3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateCheckboxSameBillingAddress3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateCheckboxSameBillingAddress3
		$I->comment("Exiting Action Group [translateCheckboxSameBillingAddress3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check button \"Place Order\"");
		$I->comment("Entering Action Group [assertButtonPlaceOrder] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertButtonPlaceOrder = $I->executeJS("return window.getComputedStyle(document.querySelector('.actions-toolbar button.checkout span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertButtonPlaceOrder
		$getBorderTypeAssertButtonPlaceOrder = $I->executeJS("return window.getComputedStyle(document.querySelector('.actions-toolbar button.checkout span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertButtonPlaceOrder
		$getBorderWidthAssertButtonPlaceOrder = $I->executeJS("return window.getComputedStyle(document.querySelector('.actions-toolbar button.checkout span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertButtonPlaceOrder
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertButtonPlaceOrder); // stepKey: assertBorderColorAssertButtonPlaceOrder
		$I->assertStringContainsString("dotted", $getBorderTypeAssertButtonPlaceOrder); // stepKey: assertBorderTypeAssertButtonPlaceOrder
		$I->assertStringContainsString("1px", $getBorderWidthAssertButtonPlaceOrder); // stepKey: assertBorderWidthAssertButtonPlaceOrder
		$I->comment("Exiting Action Group [assertButtonPlaceOrder] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateButtonPlaceOrder1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateButtonPlaceOrder1 = $I->executeJS("jQuery('.actions-toolbar button.checkout span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateButtonPlaceOrder1
		$clickBookIconTranslateButtonPlaceOrder1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateButtonPlaceOrder1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateButtonPlaceOrder1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateButtonPlaceOrder1
		$I->comment("Exiting Action Group [translateButtonPlaceOrder1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateButtonPlaceOrder2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateButtonPlaceOrder2
		$I->fillField("#translate-inline-form input.input-text", "Place Order Translated"); // stepKey: fillCustomTranslateFieldTranslateButtonPlaceOrder2
		$I->comment("Exiting Action Group [translateButtonPlaceOrder2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateButtonPlaceOrder3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateButtonPlaceOrder3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateButtonPlaceOrder3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateButtonPlaceOrder3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateButtonPlaceOrder3
		$I->comment("Exiting Action Group [translateButtonPlaceOrder3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check button \"Apply Discount Code\"");
		$I->comment("Entering Action Group [assertApplyDiscountCode] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertApplyDiscountCode = $I->executeJS("return window.getComputedStyle(document.querySelector('#block-discount-heading span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertApplyDiscountCode
		$getBorderTypeAssertApplyDiscountCode = $I->executeJS("return window.getComputedStyle(document.querySelector('#block-discount-heading span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertApplyDiscountCode
		$getBorderWidthAssertApplyDiscountCode = $I->executeJS("return window.getComputedStyle(document.querySelector('#block-discount-heading span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertApplyDiscountCode
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertApplyDiscountCode); // stepKey: assertBorderColorAssertApplyDiscountCode
		$I->assertStringContainsString("dotted", $getBorderTypeAssertApplyDiscountCode); // stepKey: assertBorderTypeAssertApplyDiscountCode
		$I->assertStringContainsString("1px", $getBorderWidthAssertApplyDiscountCode); // stepKey: assertBorderWidthAssertApplyDiscountCode
		$I->comment("Exiting Action Group [assertApplyDiscountCode] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateApplyDiscountCode1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateApplyDiscountCode1 = $I->executeJS("jQuery('#block-discount-heading span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateApplyDiscountCode1
		$clickBookIconTranslateApplyDiscountCode1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateApplyDiscountCode1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateApplyDiscountCode1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateApplyDiscountCode1
		$I->comment("Exiting Action Group [translateApplyDiscountCode1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateApplyDiscountCode2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateApplyDiscountCode2
		$I->fillField("#translate-inline-form input.input-text", "Apply Discount Code Translated"); // stepKey: fillCustomTranslateFieldTranslateApplyDiscountCode2
		$I->comment("Exiting Action Group [translateApplyDiscountCode2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateApplyDiscountCode3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateApplyDiscountCode3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateApplyDiscountCode3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateApplyDiscountCode3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateApplyDiscountCode3
		$I->comment("Exiting Action Group [translateApplyDiscountCode3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check text on sidebar \"Cart Subtotal\"");
		$I->comment("Entering Action Group [assertCartSubtotalText] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertCartSubtotalText = $I->executeJS("return window.getComputedStyle(document.querySelector('.totals.sub th.mark')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertCartSubtotalText
		$getBorderTypeAssertCartSubtotalText = $I->executeJS("return window.getComputedStyle(document.querySelector('.totals.sub th.mark')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertCartSubtotalText
		$getBorderWidthAssertCartSubtotalText = $I->executeJS("return window.getComputedStyle(document.querySelector('.totals.sub th.mark')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertCartSubtotalText
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertCartSubtotalText); // stepKey: assertBorderColorAssertCartSubtotalText
		$I->assertStringContainsString("dotted", $getBorderTypeAssertCartSubtotalText); // stepKey: assertBorderTypeAssertCartSubtotalText
		$I->assertStringContainsString("1px", $getBorderWidthAssertCartSubtotalText); // stepKey: assertBorderWidthAssertCartSubtotalText
		$I->comment("Exiting Action Group [assertCartSubtotalText] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Check translate text on sidebar \"Cart Subtotal\" as it was translated earlier in step translateCartSubtotal");
		$I->see("Cart Subtotal Translated", ".totals.sub th.mark"); // stepKey: seeTranslateCartSubtotalOnCheckoutText
		$I->comment("Check text on sidebar text \"Shipping\"");
		$I->comment("Entering Action Group [assertShippingText] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertShippingText = $I->executeJS("return window.getComputedStyle(document.querySelector('.totals.shipping span.label')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertShippingText
		$getBorderTypeAssertShippingText = $I->executeJS("return window.getComputedStyle(document.querySelector('.totals.shipping span.label')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertShippingText
		$getBorderWidthAssertShippingText = $I->executeJS("return window.getComputedStyle(document.querySelector('.totals.shipping span.label')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertShippingText
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertShippingText); // stepKey: assertBorderColorAssertShippingText
		$I->assertStringContainsString("dotted", $getBorderTypeAssertShippingText); // stepKey: assertBorderTypeAssertShippingText
		$I->assertStringContainsString("1px", $getBorderWidthAssertShippingText); // stepKey: assertBorderWidthAssertShippingText
		$I->comment("Exiting Action Group [assertShippingText] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateShippingText1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateShippingText1 = $I->executeJS("jQuery('.totals.shipping span.label').mousemove()"); // stepKey: moveMouseOverSelectorTranslateShippingText1
		$clickBookIconTranslateShippingText1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateShippingText1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateShippingText1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateShippingText1
		$I->comment("Exiting Action Group [translateShippingText1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateShippingText2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateShippingText2
		$I->fillField("#translate-inline-form input.input-text", "Shipping Translated"); // stepKey: fillCustomTranslateFieldTranslateShippingText2
		$I->comment("Exiting Action Group [translateShippingText2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateShippingText3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateShippingText3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateShippingText3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateShippingText3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateShippingText3
		$I->comment("Exiting Action Group [translateShippingText3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check text on sidebar text \"Order Total\"");
		$I->comment("Entering Action Group [assertOrderTotalText] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertOrderTotalText = $I->executeJS("return window.getComputedStyle(document.querySelector('.grand.totals th strong')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertOrderTotalText
		$getBorderTypeAssertOrderTotalText = $I->executeJS("return window.getComputedStyle(document.querySelector('.grand.totals th strong')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertOrderTotalText
		$getBorderWidthAssertOrderTotalText = $I->executeJS("return window.getComputedStyle(document.querySelector('.grand.totals th strong')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertOrderTotalText
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertOrderTotalText); // stepKey: assertBorderColorAssertOrderTotalText
		$I->assertStringContainsString("dotted", $getBorderTypeAssertOrderTotalText); // stepKey: assertBorderTypeAssertOrderTotalText
		$I->assertStringContainsString("1px", $getBorderWidthAssertOrderTotalText); // stepKey: assertBorderWidthAssertOrderTotalText
		$I->comment("Exiting Action Group [assertOrderTotalText] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateOrderTotalText1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateOrderTotalText1 = $I->executeJS("jQuery('.grand.totals th strong').mousemove()"); // stepKey: moveMouseOverSelectorTranslateOrderTotalText1
		$clickBookIconTranslateOrderTotalText1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateOrderTotalText1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateOrderTotalText1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateOrderTotalText1
		$I->comment("Exiting Action Group [translateOrderTotalText1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateOrderTotalText2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateOrderTotalText2
		$I->fillField("#translate-inline-form input.input-text", "Order Total Translated"); // stepKey: fillCustomTranslateFieldTranslateOrderTotalText2
		$I->comment("Exiting Action Group [translateOrderTotalText2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateOrderTotalText3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateOrderTotalText3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateOrderTotalText3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateOrderTotalText3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateOrderTotalText3
		$I->comment("Exiting Action Group [translateOrderTotalText3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check text on sidebar title \"Ship To\"");
		$I->comment("Entering Action Group [assertTitleShipTo] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertTitleShipTo = $I->executeJS("return window.getComputedStyle(document.querySelector('.ship-to>.shipping-information-title>span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertTitleShipTo
		$getBorderTypeAssertTitleShipTo = $I->executeJS("return window.getComputedStyle(document.querySelector('.ship-to>.shipping-information-title>span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertTitleShipTo
		$getBorderWidthAssertTitleShipTo = $I->executeJS("return window.getComputedStyle(document.querySelector('.ship-to>.shipping-information-title>span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertTitleShipTo
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertTitleShipTo); // stepKey: assertBorderColorAssertTitleShipTo
		$I->assertStringContainsString("dotted", $getBorderTypeAssertTitleShipTo); // stepKey: assertBorderTypeAssertTitleShipTo
		$I->assertStringContainsString("1px", $getBorderWidthAssertTitleShipTo); // stepKey: assertBorderWidthAssertTitleShipTo
		$I->comment("Exiting Action Group [assertTitleShipTo] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateTitleShipTo1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateTitleShipTo1 = $I->executeJS("jQuery('.ship-to>.shipping-information-title>span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateTitleShipTo1
		$clickBookIconTranslateTitleShipTo1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateTitleShipTo1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateTitleShipTo1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateTitleShipTo1
		$I->comment("Exiting Action Group [translateTitleShipTo1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateTitleShipTo2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateTitleShipTo2
		$I->fillField("#translate-inline-form input.input-text", "Ship To: Translated"); // stepKey: fillCustomTranslateFieldTranslateTitleShipTo2
		$I->comment("Exiting Action Group [translateTitleShipTo2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateTitleShipTo3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateTitleShipTo3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateTitleShipTo3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateTitleShipTo3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateTitleShipTo3
		$I->comment("Exiting Action Group [translateTitleShipTo3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Check text on sidebar title \"Shipping Method:\"");
		$I->comment("Entering Action Group [assertTitleShipVia] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertTitleShipVia = $I->executeJS("return window.getComputedStyle(document.querySelector('.ship-via>.shipping-information-title>span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertTitleShipVia
		$getBorderTypeAssertTitleShipVia = $I->executeJS("return window.getComputedStyle(document.querySelector('.ship-via>.shipping-information-title>span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertTitleShipVia
		$getBorderWidthAssertTitleShipVia = $I->executeJS("return window.getComputedStyle(document.querySelector('.ship-via>.shipping-information-title>span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertTitleShipVia
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertTitleShipVia); // stepKey: assertBorderColorAssertTitleShipVia
		$I->assertStringContainsString("dotted", $getBorderTypeAssertTitleShipVia); // stepKey: assertBorderTypeAssertTitleShipVia
		$I->assertStringContainsString("1px", $getBorderWidthAssertTitleShipVia); // stepKey: assertBorderWidthAssertTitleShipVia
		$I->comment("Exiting Action Group [assertTitleShipVia] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [translateTitleShipVia1] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorTranslateTitleShipVia1 = $I->executeJS("jQuery('.ship-via>.shipping-information-title>span').mousemove()"); // stepKey: moveMouseOverSelectorTranslateTitleShipVia1
		$clickBookIconTranslateTitleShipVia1 = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconTranslateTitleShipVia1
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearTranslateTitleShipVia1
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormTranslateTitleShipVia1
		$I->comment("Exiting Action Group [translateTitleShipVia1] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [translateTitleShipVia2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldTranslateTitleShipVia2
		$I->fillField("#translate-inline-form input.input-text", "Shipping Method: Translated"); // stepKey: fillCustomTranslateFieldTranslateTitleShipVia2
		$I->comment("Exiting Action Group [translateTitleShipVia2] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [translateTitleShipVia3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonTranslateTitleShipVia3
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonTranslateTitleShipVia3WaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearTranslateTitleShipVia3
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormTranslateTitleShipVia3
		$I->comment("Exiting Action Group [translateTitleShipVia3] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->comment("Entering Action Group [selectPaymentMethodBeforeTranslate] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectPaymentMethodBeforeTranslate
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectPaymentMethodBeforeTranslate
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectPaymentMethodBeforeTranslate
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectPaymentMethodBeforeTranslate
		$I->comment("Exiting Action Group [selectPaymentMethodBeforeTranslate] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [placeOrderBeforeTranslate] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrderBeforeTranslate
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderBeforeTranslateWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrderBeforeTranslate
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderBeforeTranslateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPlaceOrderBeforeTranslate
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrderBeforeTranslate
		$I->comment("Exiting Action Group [placeOrderBeforeTranslate] ClickPlaceOrderActionGroup");
		$I->comment("7. Set *Enabled for Storefront* option to *No* and save configuration");
		$disableTranslateInlineForStorefront = $I->magentoCLI("config:set dev/translate_inline/active 0", 60); // stepKey: disableTranslateInlineForStorefront
		$I->comment($disableTranslateInlineForStorefront);
		$I->comment("8. Clear magento cache");
		$I->comment("Entering Action Group [flushCacheAfterTranslateDisabled] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCacheAfterTranslateDisabled = $I->magentoCLI("cache:flush", 60, "translate full_page"); // stepKey: flushSpecifiedCacheFlushCacheAfterTranslateDisabled
		$I->comment($flushSpecifiedCacheFlushCacheAfterTranslateDisabled);
		$I->comment("Exiting Action Group [flushCacheAfterTranslateDisabled] CliCacheFlushActionGroup");
		$deployStaticContent = $I->magentoCLI("setup:static-content:deploy -f", 60); // stepKey: deployStaticContent
		$I->comment($deployStaticContent);
		$I->comment("9. Clear browser locale storage for magento site");
		$clearStorage = $I->executeJS("localStorage.clear();"); // stepKey: clearStorage
		$I->resetCookie("mage-translation-storage"); // stepKey: resetTranslationStorage
		$I->resetCookie("mage-translation-file-version"); // stepKey: resetTranslationFileVersion
		$I->comment("Reload page after full clear");
		$I->comment("Entering Action Group [reloadPageAfterFullClean] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPageAfterFullClean
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPageAfterFullClean
		$I->comment("Exiting Action Group [reloadPageAfterFullClean] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->comment("Add product to cart and go through Checkout process like you did in steps ##3-6 and check translation you maid.");
		$I->comment("Entering Action Group [openProductPage1] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage1
		$I->comment("Exiting Action Group [openProductPage1] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart2] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCart2
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCart2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToCart2
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart2
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCart2
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart2
		$I->comment("Exiting Action Group [addProductToCart2] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [openMiniCartTranslated] StorefrontOpenMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCartTranslated
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCartTranslatedWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCartTranslated
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCartTranslatedWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCartTranslated
		$I->comment("Exiting Action Group [openMiniCartTranslated] StorefrontOpenMiniCartActionGroup");
		$I->comment("Check translate \"Proceed to Checkout\"");
		$I->see("Proceed to Checkout Translated", "#top-cart-btn-checkout"); // stepKey: seeTranslateProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: seeTranslateProceedToCheckoutWaitForPageLoad
		$I->comment("Check translate button \"View and Edit Cart\".");
		$I->see("Edit Cart Translated", ".action.viewcart span"); // stepKey: seeTranslateViewAndEditCart
		$I->comment("Check translate \"Item in Cart\"");
		$I->see("Item in Cart Translated", ".items-total > span:nth-of-type(2)"); // stepKey: seeTranslateVisibleItemsCountText
		$I->comment("Check translate \"Cart Subtotal\"");
		$I->see("Cart Subtotal Translated", ".subtotal .label span"); // stepKey: seeTranslateCartSubtotal
		$I->comment("Check translate label \"Qty\"");
		$I->see("Qty Translated", ".details-qty label"); // stepKey: seeTranslateQty
		$I->comment("Go to checkout page");
		$I->click("#top-cart-btn-checkout"); // stepKey: toCheckout
		$I->waitForPageLoad(30); // stepKey: toCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutLoading
		$I->comment("Check translate Progress Bar Shipping");
		$I->see("Shipping Translated", ".opc-progress-bar ._active span"); // stepKey: seeTranslateProgressBarShipping
		$I->comment("Check translate step title \"Shipping Address\"");
		$I->see("Shipping address Translated", "#shipping div.step-title"); // stepKey: seeTranslateShippingAddressTitle
		$I->comment("Check translate button \"Ship Here\"");
		$I->see("Ship Here Translated", "button.action-select-shipping-item span"); // stepKey: seeTranslateButtonShipHere
		$I->comment("Check translate button \"+ New Address\"");
		$I->see("New Address Translated", ".new-address-popup button span"); // stepKey: seeTranslateButtonNewAddress
		$I->comment("Check translate title \"Shipping Method\"");
		$I->see("Shipping Methods Translated", ".checkout-shipping-method .step-title"); // stepKey: seeTranslateTitleShippingMethod
		$I->comment("Check translate button \"Next\"");
		$I->see("Next Translated", "#shipping-method-buttons-container button.primary span"); // stepKey: seeTranslateButtonNext
		$I->comment("Check translate  title \"Order Summary\"");
		$I->see("Order Summary Translated", ".opc-block-summary span.title"); // stepKey: seeTranslateTitleOrderSummary
		$I->comment("Check translate text \"Item in Cart\"");
		$I->see("Item in Cart Translated", ".items-in-cart strong span:nth-of-type(2)"); // stepKey: seeTranslateItemsInCartText
		$I->comment("Go to next step");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [gotoPaymentStep] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGotoPaymentStep
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGotoPaymentStepWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGotoPaymentStep
		$I->waitForPageLoad(30); // stepKey: clickNextGotoPaymentStepWaitForPageLoad
		$I->comment("Exiting Action Group [gotoPaymentStep] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->comment("Check translate Progress Bar Review & Payments");
		$I->see("Review & Payments Translated", ".opc-progress-bar ._active span"); // stepKey: seeTranslateProgressBarReviewAndPayments
		$I->comment("Check translate title \"Payment Method\"");
		$I->see("Payment Method Translated", ".payment-group .step-title"); // stepKey: seeTranslateTitlePayment
		$I->comment("Check translate text for checkbox \"My billing and shipping address are the same\"");
		$I->see("My billing and shipping address are the same Translated", ".billing-address-same-as-shipping-block span"); // stepKey: seeTranslateCheckboxSameBillingAddress
		$I->comment("Check translate  button \"Place Order\"");
		$I->see("Place Order Translated", ".actions-toolbar button.checkout span"); // stepKey: seeTranslateButtonPlaceOrder
		$I->comment("Check translate button \"Apply Discount Code\"");
		$I->see("Apply Discount Code Translated", "#block-discount-heading span"); // stepKey: seeTranslateApplyDiscountCode
		$I->comment("Check translate text on sidebar \"Cart Subtotal\"");
		$I->see("Cart Subtotal Translated", ".totals.sub th.mark"); // stepKey: seeTranslateCartSubtotalText
		$I->comment("Check translate text on sidebar text \"Shipping\"");
		$I->see("Shipping Translated", ".totals.shipping span.label"); // stepKey: seeTranslateShippingText
		$I->comment("Check translate text on sidebar text \"Order Total\"");
		$I->see("Order Total Translated", ".grand.totals th strong"); // stepKey: seeTranslateOrderTotalText
		$I->comment("Check translate text on sidebar title \"Ship To\"");
		$I->see("Ship To: Translated", ".ship-to>.shipping-information-title>span"); // stepKey: seeTranslateTitleShipTo
		$I->comment("Check translate text on sidebar title \"Shipping Method:\"");
		$I->see("Shipping Method: Translated", ".ship-via>.shipping-information-title>span"); // stepKey: seeTranslateTitleShipVia
		$I->comment("Entering Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectPaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectPaymentMethod
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectPaymentMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectPaymentMethod
		$I->comment("Exiting Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlaceOrder
		$I->comment("Exiting Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
	}
}
