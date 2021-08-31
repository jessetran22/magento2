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
 * @Title("MC-41175: Inline translation with quote symbols")
 * @Description("As merchant I want to be able to rename text labels using quote symbols in it<h3>Test files</h3>app/code/Magento/Translation/Test/Mftf/Test/StorefrontInlineTranslationWithQuoteSymbolsTest.xml<br>")
 * @TestCaseId("MC-41175")
 * @group translation
 * @group developer_mode_only
 */
class StorefrontInlineTranslationWithQuoteSymbolsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createCustomer
		$enableTranslateInlineStorefront = $I->magentoCLI("config:set dev/translate_inline/active 1", 60); // stepKey: enableTranslateInlineStorefront
		$I->comment($enableTranslateInlineStorefront);
		$I->createEntity("revertWelcomeMessageTranslation", "hook", "RevertWelcomeMessageTranslate", ["createCustomer"], []); // stepKey: revertWelcomeMessageTranslation
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->createEntity("createProductSecond", "hook", "SimpleProduct2", [], []); // stepKey: createProductSecond
		$I->comment("Entering Action Group [cleanCacheAfterTranslateEnabled] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCacheAfterTranslateEnabled = $I->magentoCLI("cache:clean", 60, ""); // stepKey: cleanSpecifiedCacheCleanCacheAfterTranslateEnabled
		$I->comment($cleanSpecifiedCacheCleanCacheAfterTranslateEnabled);
		$I->comment("Exiting Action Group [cleanCacheAfterTranslateEnabled] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableTranslateInlineStorefront = $I->magentoCLI("config:set dev/translate_inline/active 1", 60); // stepKey: enableTranslateInlineStorefront
		$I->comment($enableTranslateInlineStorefront);
		$I->createEntity("revertWelcomeMessageTranslation", "hook", "RevertWelcomeMessageTranslate", ["createCustomer"], []); // stepKey: revertWelcomeMessageTranslation
		$disableTranslateInlineForStorefront = $I->magentoCLI("config:set dev/translate_inline/active 0", 60); // stepKey: disableTranslateInlineForStorefront
		$I->comment($disableTranslateInlineForStorefront);
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createProductSecond", "hook"); // stepKey: deleteProductSecond
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [cleanCacheAfterTranslateDisabled] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCacheAfterTranslateDisabled = $I->magentoCLI("cache:clean", 60, ""); // stepKey: cleanSpecifiedCacheCleanCacheAfterTranslateDisabled
		$I->comment($cleanSpecifiedCacheCleanCacheAfterTranslateDisabled);
		$I->comment("Exiting Action Group [cleanCacheAfterTranslateDisabled] CliCacheCleanActionGroup");
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
	public function StorefrontInlineTranslationWithQuoteSymbolsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [assertDefaultWelcomeMessage] AssertStorefrontDefaultWelcomeMessageActionGroup");
		$I->waitForElementVisible("header>.panel .greet.welcome", 30); // stepKey: waitDefaultMessageAssertDefaultWelcomeMessage
		$I->see("Default welcome msg!", "header>.panel .greet.welcome"); // stepKey: verifyDefaultMessageAssertDefaultWelcomeMessage
		$I->dontSeeElement(".greet.welcome span a"); // stepKey: checkAbsenceLinkNotYouAssertDefaultWelcomeMessage
		$I->comment("Exiting Action Group [assertDefaultWelcomeMessage] AssertStorefrontDefaultWelcomeMessageActionGroup");
		$I->comment("Entering Action Group [addProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSeeProductInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartSeeProductInMiniCart
		$I->comment("Exiting Action Group [seeProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Entering Action Group [assertWelcomeMessageInInlineTranslateMode] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertWelcomeMessageInInlineTranslateMode = $I->executeJS("return window.getComputedStyle(document.querySelector('header>.panel .greet.welcome span')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertWelcomeMessageInInlineTranslateMode
		$getBorderTypeAssertWelcomeMessageInInlineTranslateMode = $I->executeJS("return window.getComputedStyle(document.querySelector('header>.panel .greet.welcome span')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertWelcomeMessageInInlineTranslateMode
		$getBorderWidthAssertWelcomeMessageInInlineTranslateMode = $I->executeJS("return window.getComputedStyle(document.querySelector('header>.panel .greet.welcome span')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertWelcomeMessageInInlineTranslateMode
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertWelcomeMessageInInlineTranslateMode); // stepKey: assertBorderColorAssertWelcomeMessageInInlineTranslateMode
		$I->assertStringContainsString("dotted", $getBorderTypeAssertWelcomeMessageInInlineTranslateMode); // stepKey: assertBorderTypeAssertWelcomeMessageInInlineTranslateMode
		$I->assertStringContainsString("1px", $getBorderWidthAssertWelcomeMessageInInlineTranslateMode); // stepKey: assertBorderWidthAssertWelcomeMessageInInlineTranslateMode
		$I->comment("Exiting Action Group [assertWelcomeMessageInInlineTranslateMode] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Entering Action Group [openWelcomeMessageInlineTranslatePopup] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorOpenWelcomeMessageInlineTranslatePopup = $I->executeJS("jQuery('header>.panel .greet.welcome span').mousemove()"); // stepKey: moveMouseOverSelectorOpenWelcomeMessageInlineTranslatePopup
		$clickBookIconOpenWelcomeMessageInlineTranslatePopup = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconOpenWelcomeMessageInlineTranslatePopup
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearOpenWelcomeMessageInlineTranslatePopup
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormOpenWelcomeMessageInlineTranslatePopup
		$I->comment("Exiting Action Group [openWelcomeMessageInlineTranslatePopup] StorefrontOpenInlineTranslationPopupActionGroup");
		$I->comment("Entering Action Group [fillInlineTranslateNewValue] StorefrontFillCustomTranslationFieldActionGroup");
		$I->clearField("#translate-inline-form input.input-text"); // stepKey: clearCustomTranslateFieldFillInlineTranslateNewValue
		$I->fillField("#translate-inline-form input.input-text", "Welcome to \"Food & Drinks\" store"); // stepKey: fillCustomTranslateFieldFillInlineTranslateNewValue
		$I->comment("Exiting Action Group [fillInlineTranslateNewValue] StorefrontFillCustomTranslationFieldActionGroup");
		$I->comment("Entering Action Group [saveInlineTranslateNewValue] StorefrontSubmitInlineTranslationFormActionGroup");
		$I->click("button.action-primary"); // stepKey: clickSubmitButtonSaveInlineTranslateNewValue
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonSaveInlineTranslateNewValueWaitForPageLoad
		$I->waitForElementNotVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupDisappearSaveInlineTranslateNewValue
		$I->dontSeeElement("#translate-inline-form"); // stepKey: dontSeeTranslateFormSaveInlineTranslateNewValue
		$I->comment("Exiting Action Group [saveInlineTranslateNewValue] StorefrontSubmitInlineTranslationFormActionGroup");
		$disableTranslateInlineForStorefront = $I->magentoCLI("config:set dev/translate_inline/active 0", 60); // stepKey: disableTranslateInlineForStorefront
		$I->comment($disableTranslateInlineForStorefront);
		$I->comment("Entering Action Group [cleanCacheAfterTranslateDisabled] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCacheAfterTranslateDisabled = $I->magentoCLI("cache:clean", 60, ""); // stepKey: cleanSpecifiedCacheCleanCacheAfterTranslateDisabled
		$I->comment($cleanSpecifiedCacheCleanCacheAfterTranslateDisabled);
		$I->comment("Exiting Action Group [cleanCacheAfterTranslateDisabled] CliCacheCleanActionGroup");
		$I->comment("Entering Action Group [reloadPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage
		$I->comment("Exiting Action Group [reloadPage] ReloadPageActionGroup");
		$I->comment("Entering Action Group [verifyTranslatedWelcomeMessage] AssertStorefrontCustomWelcomeMessageActionGroup");
		$I->waitForElementVisible("header>.panel .greet.welcome", 30); // stepKey: waitForWelcomeMessageVerifyTranslatedWelcomeMessage
		$I->see("Welcome to \"Food & Drinks\" store", "header>.panel .greet.welcome"); // stepKey: verifyCustomMessageVerifyTranslatedWelcomeMessage
		$I->comment("Exiting Action Group [verifyTranslatedWelcomeMessage] AssertStorefrontCustomWelcomeMessageActionGroup");
		$I->comment("Entering Action Group [seeProductInMiniCartAgain] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSeeProductInMiniCartAgain
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCartAgain
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCartAgainWaitForPageLoad
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartSeeProductInMiniCartAgain
		$I->comment("Exiting Action Group [seeProductInMiniCartAgain] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Entering Action Group [openSecondProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProductSecond', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenSecondProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSecondProductPage
		$I->comment("Exiting Action Group [openSecondProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [verifyTranslatedWelcomeMessageForSecondProduct] AssertStorefrontCustomWelcomeMessageActionGroup");
		$I->waitForElementVisible("header>.panel .greet.welcome", 30); // stepKey: waitForWelcomeMessageVerifyTranslatedWelcomeMessageForSecondProduct
		$I->see("Welcome to \"Food & Drinks\" store", "header>.panel .greet.welcome"); // stepKey: verifyCustomMessageVerifyTranslatedWelcomeMessageForSecondProduct
		$I->comment("Exiting Action Group [verifyTranslatedWelcomeMessageForSecondProduct] AssertStorefrontCustomWelcomeMessageActionGroup");
		$I->comment("Entering Action Group [addSecondProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddSecondProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddSecondProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddSecondProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSecondProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSecondProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSecondProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProductSecond', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSecondProductToCart
		$I->comment("Exiting Action Group [addSecondProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [seeSecondProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSeeSecondProductInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSeeSecondProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSeeSecondProductInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('createProductSecond', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartSeeSecondProductInMiniCart
		$I->comment("Exiting Action Group [seeSecondProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
	}
}
