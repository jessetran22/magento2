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
 * @Title("MC-14670: Create enabled text checkout multishipping agreement")
 * @Description("Admin should be able to create enabled text checkout multishipping agreement<h3>Test files</h3>app/code/Magento/CheckoutAgreements/Test/Mftf/Test/AdminCreateEnabledTextTermOnMultishippingEntityTest.xml<br>")
 * @TestCaseId("MC-14670")
 * @group checkoutAgreements
 * @group mtf_migrated
 */
class AdminCreateEnabledTextTermOnMultishippingEntityTestCest
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
		$setEnableTermsOnCheckout = $I->magentoCLI("config:set checkout/options/enable_agreements 1", 60); // stepKey: setEnableTermsOnCheckout
		$I->comment($setEnableTermsOnCheckout);
		$I->createEntity("createdCustomer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createdCustomer
		$I->createEntity("createdProduct1", "hook", "SimpleTwo", [], []); // stepKey: createdProduct1
		$I->createEntity("createdProduct2", "hook", "SimpleTwo", [], []); // stepKey: createdProduct2
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Entering Action Group [adminLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminLogin
		$I->comment("Exiting Action Group [adminLogin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setDisableTermsOnCheckout = $I->magentoCLI("config:set checkout/options/enable_agreements 0", 60); // stepKey: setDisableTermsOnCheckout
		$I->comment($setDisableTermsOnCheckout);
		$I->deleteEntity("createdCustomer", "hook"); // stepKey: deletedCustomer
		$I->deleteEntity("createdProduct1", "hook"); // stepKey: deletedProduct1
		$I->deleteEntity("createdProduct2", "hook"); // stepKey: deletedProduct2
		$I->comment("Entering Action Group [openTermsGridToDelete] AdminTermsConditionsOpenGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/checkout/agreement/"); // stepKey: onTermGridPageOpenTermsGridToDelete
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenTermsGridToDelete
		$I->comment("Exiting Action Group [openTermsGridToDelete] AdminTermsConditionsOpenGridActionGroup");
		$I->comment("Entering Action Group [openTermToDelete] AdminTermsConditionsEditTermByNameActionGroup");
		$I->fillField("#agreementGrid_filter_name", "name" . msq("activeTextTerm")); // stepKey: fillTermNameFilterOpenTermToDelete
		$I->click("//div[contains(@class,'admin__data-grid-header')]//div[contains(@class,'admin__filter-actions')]/button[1]"); // stepKey: clickSearchButtonOpenTermToDelete
		$I->click(".data-grid>tbody>tr>td.col-id.col-agreement_id"); // stepKey: clickFirstRowOpenTermToDelete
		$I->waitForPageLoad(30); // stepKey: waitForEditTermPageLoadOpenTermToDelete
		$I->comment("Exiting Action Group [openTermToDelete] AdminTermsConditionsEditTermByNameActionGroup");
		$I->comment("Entering Action Group [deleteOpenedTerm] AdminTermsConditionsDeleteTermByNameActionGroup");
		$I->click(".page-main-actions #delete"); // stepKey: clickDeleteButtonDeleteOpenedTerm
		$I->waitForElementVisible("button.action-primary.action-accept", 30); // stepKey: waitForElementDeleteOpenedTerm
		$I->click("button.action-primary.action-accept"); // stepKey: clickDeleteOkButtonDeleteOpenedTerm
		$I->waitForText("You deleted the condition.", 30, ".message-success"); // stepKey: seeSuccessMessageDeleteOpenedTerm
		$I->comment("Exiting Action Group [deleteOpenedTerm] AdminTermsConditionsDeleteTermByNameActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"CheckoutAgreements"})
	 * @Stories({"Checkout agreements"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateEnabledTextTermOnMultishippingEntityTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewTerm] AdminTermsConditionsOpenNewTermPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/checkout/agreement/new"); // stepKey: amOnNewTermPageOpenNewTerm
		$I->waitForPageLoad(30); // stepKey: waitForAdminNewTermPageLoadOpenNewTerm
		$I->comment("Exiting Action Group [openNewTerm] AdminTermsConditionsOpenNewTermPageActionGroup");
		$I->comment("Entering Action Group [fillNewTerm] AdminTermsConditionsFillTermEditFormActionGroup");
		$I->fillField("#name", "name" . msq("activeTextTerm")); // stepKey: fillFieldConditionNameFillNewTerm
		$I->selectOption("#is_active", "Enabled"); // stepKey: selectOptionIsActiveFillNewTerm
		$I->selectOption("#is_html", "Text"); // stepKey: selectOptionIsHtmlFillNewTerm
		$I->selectOption("#mode", "Manually"); // stepKey: selectOptionModeFillNewTerm
		$I->selectOption("#stores", "Default Store View"); // stepKey: selectOptionStoreViewFillNewTerm
		$I->fillField("#checkbox_text", "test_checkbox" . msq("activeTextTerm")); // stepKey: fillFieldCheckboxTextFillNewTerm
		$I->fillField("#content", "TestMessage" . msq("activeTextTerm")); // stepKey: fillFieldContentFillNewTerm
		$I->comment("Exiting Action Group [fillNewTerm] AdminTermsConditionsFillTermEditFormActionGroup");
		$I->comment("Entering Action Group [saveNewTerm] AdminTermsConditionsSaveTermActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveTermSaveNewTerm
		$I->see("You saved the condition.", ".message-success"); // stepKey: seeSuccessMessageSaveNewTerm
		$I->comment("Exiting Action Group [saveNewTerm] AdminTermsConditionsSaveTermActionGroup");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createdCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createdCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [addProduct1ToTheCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createdProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProduct1ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProduct1ToTheCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProduct1ToTheCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProduct1ToTheCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct1ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct1ToTheCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProduct1ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct1ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProduct1ToTheCart
		$I->see("You added " . $I->retrieveEntityField('createdProduct1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct1ToTheCart
		$I->comment("Exiting Action Group [addProduct1ToTheCart] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [addProduct2ToTheCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createdProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProduct2ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProduct2ToTheCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProduct2ToTheCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProduct2ToTheCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct2ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct2ToTheCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProduct2ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct2ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProduct2ToTheCart
		$I->see("You added " . $I->retrieveEntityField('createdProduct2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct2ToTheCart
		$I->comment("Exiting Action Group [addProduct2ToTheCart] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [assertTermInCheckout] AssertStorefrontTermRequireMessageInMultishippingCheckoutActionGroup");
		$I->comment("Go to Checkout Cart and proceed with multiple addresses");
		$I->amOnPage("/checkout/cart"); // stepKey: goToCheckoutCartAssertTermInCheckout
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadAssertTermInCheckout
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: proceedMultishippingAssertTermInCheckout
		$I->comment("Procees do overview page");
		$I->click("button.action.primary.continue"); // stepKey: clickGoToShippingInformationAssertTermInCheckout
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutAddressToolbarPageLoadAssertTermInCheckout
		$I->click("button.action.primary.continue"); // stepKey: clickContinueToBillingAssertTermInCheckout
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutShippingToolbarPageLoadAssertTermInCheckout
		$I->click("button.action.primary.continue"); // stepKey: clickGoToReviewOrderAssertTermInCheckout
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutBillingToolbarPageLoadAssertTermInCheckout
		$I->comment("Check if agreement is present on checkout and select it");
		$I->scrollTo("button.action.primary.submit"); // stepKey: scrollToButtonPlaceOrderAssertTermInCheckout
		$I->see("test_checkbox" . msq("activeTextTerm"), "div.checkout-agreements-block > div > div > div > label > button > span"); // stepKey: seeTermInCheckoutAssertTermInCheckout
		$I->click("button.action.primary.submit"); // stepKey: tryToPlaceOrder1AssertTermInCheckout
		$I->see("This is a required field.", "div.checkout-agreement.field.choice.required > div.mage-error"); // stepKey: seeErrorMessageAssertTermInCheckout
		$I->selectOption("div.checkout-agreement.field.choice.required > input", "test_checkbox" . msq("activeTextTerm")); // stepKey: checkAgreementAssertTermInCheckout
		$I->click("button.action.primary.submit"); // stepKey: tryToPlaceOrder2AssertTermInCheckout
		$I->dontSee("This is a required field.", "div.checkout-agreement.field.choice.required > div.mage-error"); // stepKey: dontSeeErrorMessageAssertTermInCheckout
		$I->comment("See success message");
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: seeSuccessTitleAssertTermInCheckout
		$I->comment("Exiting Action Group [assertTermInCheckout] AssertStorefrontTermRequireMessageInMultishippingCheckoutActionGroup");
	}
}
