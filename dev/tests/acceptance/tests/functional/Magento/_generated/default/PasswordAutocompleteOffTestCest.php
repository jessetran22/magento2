<?php
namespace Magento\AcceptanceTest\_default\Backend;

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
 * @Title("MC-13678: [Security] Autocomplete attribute with off value is added to password input")
 * @Description("[Security] Autocomplete attribute with off value is added to password input<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/PasswordAutocompleteOffTest.xml<br>")
 * @TestCaseId("MC-13678")
 * @group customers
 * @group mtf_migrated
 */
class PasswordAutocompleteOffTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Configure Magento via CLI: disable_guest_checkout");
		$disableGuestCheckout = $I->magentoCLI("config:set checkout/options/guest_checkout 0", 60); // stepKey: disableGuestCheckout
		$I->comment($disableGuestCheckout);
		$I->comment("Configure Magento via CLI: password_autocomplete_off");
		$turnPasswordAutocompleteOff = $I->magentoCLI("config:set customer/password/autocomplete_on_storefront 0", 60); // stepKey: turnPasswordAutocompleteOff
		$I->comment($turnPasswordAutocompleteOff);
		$I->comment("Create a simple product");
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "SimpleProduct", ["category"], []); // stepKey: product
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set Magento configuration back to default values");
		$disableGuestCheckoutRollback = $I->magentoCLI("config:set checkout/options/guest_checkout 1", 60); // stepKey: disableGuestCheckoutRollback
		$I->comment($disableGuestCheckoutRollback);
		$turnPasswordAutocompleteOffRollback = $I->magentoCLI("config:set customer/password/autocomplete_on_storefront 1", 60); // stepKey: turnPasswordAutocompleteOffRollback
		$I->comment($turnPasswordAutocompleteOffRollback);
		$I->comment("Delete the simple product created in the before block");
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Customer"})
	 * @Stories({"Customer Password Autocomplete"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function PasswordAutocompleteOffTest(AcceptanceTester $I)
	{
		$I->comment("Go to the created product page and add it to the cart");
		$I->comment("Entering Action Group [cartAddSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartAddSimpleProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartCartAddSimpleProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartAddSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartAddSimpleProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('product', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartAddSimpleProductToCart
		$I->comment("Exiting Action Group [cartAddSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Click Sign in - on the top right of the page");
		$I->comment("Entering Action Group [storeFrontClickSignInButton] StorefrontClickSignInButtonActionGroup");
		$I->click(".panel.header .header.links .authorization-link a"); // stepKey: signInStoreFrontClickSignInButton
		$I->waitForPageLoad(30); // stepKey: signInStoreFrontClickSignInButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontSignInPageLoadStoreFrontClickSignInButton
		$I->comment("Exiting Action Group [storeFrontClickSignInButton] StorefrontClickSignInButtonActionGroup");
		$I->comment("Verify if the password field on store front sign-in page has the autocomplete attribute set to off");
		$I->comment("Entering Action Group [assertStorefrontPasswordAutoCompleteOff] AssertStorefrontPasswordAutoCompleteOffActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageAssertStorefrontPasswordAutoCompleteOff
		$I->assertElementContainsAttribute("#pass", "autocomplete", "off"); // stepKey: assertSignInPasswordAutocompleteOffAssertStorefrontPasswordAutoCompleteOff
		$I->comment("Exiting Action Group [assertStorefrontPasswordAutoCompleteOff] AssertStorefrontPasswordAutoCompleteOffActionGroup");
		$I->comment("Proceed to checkout");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Verify if the password field on the authorization popup has the autocomplete attribute set to off");
		$I->comment("Entering Action Group [assertAuthorizationPopUpPasswordAutoCompleteOff] AssertAuthorizationPopUpPasswordAutoCompleteOffActionGroup");
		$I->waitForElementVisible("#pass", 30); // stepKey: waitPasswordFieldVisibleAssertAuthorizationPopUpPasswordAutoCompleteOff
		$I->assertElementContainsAttribute("#pass", "autocomplete", "off"); // stepKey: assertAuthorizationPopupPasswordAutocompleteOffAssertAuthorizationPopUpPasswordAutoCompleteOff
		$I->comment("Exiting Action Group [assertAuthorizationPopUpPasswordAutoCompleteOff] AssertAuthorizationPopUpPasswordAutoCompleteOffActionGroup");
	}
}
