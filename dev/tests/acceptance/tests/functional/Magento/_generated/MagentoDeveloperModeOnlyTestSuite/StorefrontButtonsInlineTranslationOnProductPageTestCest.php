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
 * @Title("MC-27118: Buttons inline translation on product page")
 * @Description("A merchant should be able to translate buttons by an inline translation tool<h3>Test files</h3>app/code/Magento/Translation/Test/Mftf/Test/StorefrontButtonsInlineTranslationOnProductPageTest.xml<br>")
 * @TestCaseId("MC-27118")
 * @group translation
 * @group catalog
 * @group developer_mode_only
 */
class StorefrontButtonsInlineTranslationOnProductPageTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Enable Translate Inline For Storefront");
		$enableTranslateInlineForStorefront = $I->magentoCLI("config:set dev/translate_inline/active 1", 60); // stepKey: enableTranslateInlineForStorefront
		$I->comment($enableTranslateInlineForStorefront);
		$I->comment("Create Simple Product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Disable Translate Inline For Storefront");
		$disableTranslateInlineForStorefront = $I->magentoCLI("config:set dev/translate_inline/active 0", 60); // stepKey: disableTranslateInlineForStorefront
		$I->comment($disableTranslateInlineForStorefront);
		$I->comment("Delete Simple Product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	public function StorefrontButtonsInlineTranslationOnProductPageTest(AcceptanceTester $I)
	{
		$I->comment("Add product to cart on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->waitForElementVisible("button#product-addtocart-button[data-translate]:enabled", 30); // stepKey: waitForAddToCartButtonEnabled
		$I->waitForPageLoad(60); // stepKey: waitForAddToCartButtonEnabledWaitForPageLoad
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
		$I->comment("Open Mini Cart");
		$I->comment("Entering Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart
		$I->comment("Exiting Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->comment("Check button \"Proceed to Checkout\". There must be red borders and \"book\" icons on labels that can be translated.");
		$I->comment("Entering Action Group [assertRedBordersAndBookIcon] AssertElementInTranslateInlineModeActionGroup");
		$getBorderColorAssertRedBordersAndBookIcon = $I->executeJS("return window.getComputedStyle(document.querySelector('#top-cart-btn-checkout')).getPropertyValue('outline-color')"); // stepKey: getBorderColorAssertRedBordersAndBookIcon
		$I->waitForPageLoad(30); // stepKey: getBorderColorAssertRedBordersAndBookIconWaitForPageLoad
		$getBorderTypeAssertRedBordersAndBookIcon = $I->executeJS("return window.getComputedStyle(document.querySelector('#top-cart-btn-checkout')).getPropertyValue('outline-style')"); // stepKey: getBorderTypeAssertRedBordersAndBookIcon
		$I->waitForPageLoad(30); // stepKey: getBorderTypeAssertRedBordersAndBookIconWaitForPageLoad
		$getBorderWidthAssertRedBordersAndBookIcon = $I->executeJS("return window.getComputedStyle(document.querySelector('#top-cart-btn-checkout')).getPropertyValue('outline-width')"); // stepKey: getBorderWidthAssertRedBordersAndBookIcon
		$I->waitForPageLoad(30); // stepKey: getBorderWidthAssertRedBordersAndBookIconWaitForPageLoad
		$I->assertStringContainsString("rgb(255, 0, 0)", $getBorderColorAssertRedBordersAndBookIcon); // stepKey: assertBorderColorAssertRedBordersAndBookIcon
		$I->assertStringContainsString("dotted", $getBorderTypeAssertRedBordersAndBookIcon); // stepKey: assertBorderTypeAssertRedBordersAndBookIcon
		$I->assertStringContainsString("1px", $getBorderWidthAssertRedBordersAndBookIcon); // stepKey: assertBorderWidthAssertRedBordersAndBookIcon
		$I->comment("Exiting Action Group [assertRedBordersAndBookIcon] AssertElementInTranslateInlineModeActionGroup");
		$I->comment("Open Inline Translation popup");
		$I->comment("Entering Action Group [openInlineTranslationPopup] StorefrontOpenInlineTranslationPopupActionGroup");
		$moveMouseOverSelectorOpenInlineTranslationPopup = $I->executeJS("jQuery('#top-cart-btn-checkout').mousemove()"); // stepKey: moveMouseOverSelectorOpenInlineTranslationPopup
		$I->waitForPageLoad(30); // stepKey: moveMouseOverSelectorOpenInlineTranslationPopupWaitForPageLoad
		$clickBookIconOpenInlineTranslationPopup = $I->executeJS("jQuery('.translate-edit-icon').click()"); // stepKey: clickBookIconOpenInlineTranslationPopup
		$I->waitForElementVisible("#translate-inline-form", 30); // stepKey: waitForTranslationPopupAppearOpenInlineTranslationPopup
		$I->seeElement("#translate-inline-form"); // stepKey: seeTranslateFormOpenInlineTranslationPopup
		$I->comment("Exiting Action Group [openInlineTranslationPopup] StorefrontOpenInlineTranslationPopupActionGroup");
	}
}
