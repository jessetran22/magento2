<?php
namespace Magento\AcceptanceTest\_SecureStorefrontURLSuite\Backend;

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
 * @Title("MC-15531: Verify Secure URLs For Storefront Checkout Pages")
 * @Description("Verify that the Secure URL configuration applies to the Checkout pages on the Storefront<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontVerifySecureURLRedirectCheckoutTest.xml<br>")
 * @TestCaseId("MC-15531")
 * @group checkout
 * @group configuration
 * @group secure_storefront_url
 */
class StorefrontVerifySecureURLRedirectCheckoutTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "_defaultProduct", ["category"], []); // stepKey: product
		$I->amOnPage("/" . $I->retrieveEntityField('category', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Entering Action Group [moveMouseOverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductMoveMouseOverProduct
		$I->comment("Exiting Action Group [moveMouseOverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickAddToCartButton] StorefrontClickAddToCartButtonActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartClickAddToCartButton
		$I->waitForPageLoad(30); // stepKey: waitAddToCartClickAddToCartButton
		$I->comment("Exiting Action Group [clickAddToCartButton] StorefrontClickAddToCartButtonActionGroup");
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForAddedToCartSuccessMessage
		$I->see("You added " . $I->retrieveEntityField('product', 'name', 'hook') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartSuccessMessage
		$I->see("1", "span.counter-number"); // stepKey: seeCartQuantity
		$hostname = $I->executeJS("return window.location.host"); // stepKey: hostname
		$setSecureBaseURL = $I->magentoCLI("config:set web/secure/base_url https://{$hostname}/", 60); // stepKey: setSecureBaseURL
		$I->comment($setSecureBaseURL);
		$useSecureURLsOnStorefront = $I->magentoCLI("config:set web/secure/use_in_frontend 1", 60); // stepKey: useSecureURLsOnStorefront
		$I->comment($useSecureURLsOnStorefront);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$dontUseSecureURLsOnStorefront = $I->magentoCLI("config:set web/secure/use_in_frontend 0", 60); // stepKey: dontUseSecureURLsOnStorefront
		$I->comment($dontUseSecureURLsOnStorefront);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"Checkout"})
	 * @Stories({"Storefront Secure URLs"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifySecureURLRedirectCheckoutTest(AcceptanceTester $I)
	{
		$hostname = $I->executeJS("return window.location.host"); // stepKey: hostname
		$I->amOnUrl("http://{$hostname}/checkout"); // stepKey: goToUnsecureCheckoutURL
		$I->seeCurrentUrlEquals("https://{$hostname}/checkout"); // stepKey: seeSecureCheckoutURL
		$I->amOnUrl("http://{$hostname}/checkout/sidebar"); // stepKey: goToUnsecureCheckoutSidebarURL
		$I->seeCurrentUrlEquals("http://{$hostname}/checkout/sidebar"); // stepKey: seeUnsecureCheckoutSidebarURL
	}
}
