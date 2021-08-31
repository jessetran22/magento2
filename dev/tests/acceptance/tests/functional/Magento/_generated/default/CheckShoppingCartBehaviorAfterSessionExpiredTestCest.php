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
 * @Title("MAGETWO-95118: Checking behavior with the persistent shopping cart after the session is expired")
 * @Description("Checking behavior with the persistent shopping cart after the session is expired<h3>Test files</h3>app/code/Magento/Persistent/Test/Mftf/Test/CheckShoppingCartBehaviorAfterSessionExpiredTest.xml<br>")
 * @TestCaseId("MAGETWO-95118")
 * @group persistent
 */
class CheckShoppingCartBehaviorAfterSessionExpiredTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Enable Persistence");
		$I->createEntity("enablePersistent", "hook", "PersistentConfigEnabled", [], []); // stepKey: enablePersistent
		$I->comment("Create product");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Create new customer");
		$I->comment("Entering Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageOpenCreateAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCreateAccountPage
		$I->comment("Exiting Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->comment("Entering Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillCreateAccountForm
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillCreateAccountForm
		$I->fillField("#email_address", msq("Simple_US_Customer_NY") . "John.Doe@example.com"); // stepKey: fillEmailFillCreateAccountForm
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillCreateAccountForm
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillCreateAccountForm
		$I->comment("Exiting Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSubmitCreateAccountForm
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSubmitCreateAccountForm
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSubmitCreateAccountFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedSubmitCreateAccountForm
		$I->comment("Exiting Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->comment("Add shipping information");
		$I->comment("Entering Action Group [enterAddressInfo] EnterCustomerAddressInfoActionGroup");
		$I->amOnPage("customer/address/new/"); // stepKey: goToAddressPageEnterAddressInfo
		$I->waitForPageLoad(30); // stepKey: waitForAddressPageEnterAddressInfo
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameEnterAddressInfo
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameEnterAddressInfo
		$I->fillField("#company", "368"); // stepKey: fillCompanyEnterAddressInfo
		$I->fillField("#telephone", "512-345-6789"); // stepKey: fillPhoneNumberEnterAddressInfo
		$I->fillField("#street_1", "368 Broadway St."); // stepKey: fillStreetAddress1EnterAddressInfo
		$I->fillField("#street_2", "113"); // stepKey: fillStreetAddress2EnterAddressInfo
		$I->fillField("#city", "New York"); // stepKey: fillCityNameEnterAddressInfo
		$I->selectOption("#country", "US"); // stepKey: selectCountyEnterAddressInfo
		$I->selectOption("#region_id", "New York"); // stepKey: selectStateEnterAddressInfo
		$I->fillField("#zip", "10001"); // stepKey: fillZipEnterAddressInfo
		$I->click("[data-action='save-address']"); // stepKey: saveAddressEnterAddressInfo
		$I->waitForPageLoad(30); // stepKey: saveAddressEnterAddressInfoWaitForPageLoad
		$I->comment("Exiting Action Group [enterAddressInfo] EnterCustomerAddressInfoActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Roll back configuration");
		$I->createEntity("setDefaultPersistentState", "hook", "PersistentConfigDefault", [], []); // stepKey: setDefaultPersistentState
		$I->comment("Delete product");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Persistent"})
	 * @Stories({"MAGETWO-91733 - Unusual behavior with the persistent shopping cart after the session is expired"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CheckShoppingCartBehaviorAfterSessionExpiredTest(AcceptanceTester $I)
	{
		$I->comment("Add simple product to cart");
		$I->comment("Entering Action Group [addProductToCart1] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCart1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart1
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart1
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCart1WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart1
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart1
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart1
		$I->comment("Exiting Action Group [addProductToCart1] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCartFromMinicart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCartFromMinicart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCartFromMinicart
		$I->comment("Exiting Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Reset cookies and refresh the page");
		$I->resetCookie("PHPSESSID"); // stepKey: resetCookieForCart
		$I->comment("Entering Action Group [reloadPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage
		$I->comment("Exiting Action Group [reloadPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->comment("Check product exists in cart");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: ProductExistsInCart
	}
}
