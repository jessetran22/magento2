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
 * @Title("MAGETWO-93289: Adding a product to cart from category page with an expired session")
 * @Description("Adding a product to cart from category page with an expired session<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontAddProductToCartWithExpiredSessionTest.xml<br>")
 * @TestCaseId("MAGETWO-93289")
 * @group customer
 */
class StorefrontAddProductToCartWithExpiredSessionTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$runCronReindex = $I->magentoCron("index", 90); // stepKey: runCronReindex
		$I->comment($runCronReindex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Stories({"MAGETWO-66666: Adding a product to cart from category page with an expired session does not allow product to be added"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddProductToCartWithExpiredSessionTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [fakeBrokenSession] StorefrontFakeBrokenSessionActionGroup");
		$I->resetCookie("PHPSESSID"); // stepKey: resetCookieForCartFakeBrokenSession
		$I->resetCookie("form_key"); // stepKey: resetCookieForCart2FakeBrokenSession
		$I->comment("Exiting Action Group [fakeBrokenSession] StorefrontFakeBrokenSessionActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontProductPageAddSimpleProductToCartActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontProductPageAddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [assertFailure] StorefrontAssertProductAddToCartErrorMessageActionGroup");
		$I->waitForElementVisible("div.message-error.error.message", 10); // stepKey: waitForProductAddedMessageAssertFailure
		$I->see("Your session has expired", "div.message-error.error.message"); // stepKey: seeAddToCartErrorMessageAssertFailure
		$I->comment("Exiting Action Group [assertFailure] StorefrontAssertProductAddToCartErrorMessageActionGroup");
	}
}
