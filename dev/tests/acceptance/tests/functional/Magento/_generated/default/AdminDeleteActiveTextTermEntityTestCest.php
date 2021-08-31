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
 * @Title("MC-14663: Delete active text checkout agreement")
 * @Description("Admin should be able to delete active text checkout agreement<h3>Test files</h3>app/code/Magento/CheckoutAgreements/Test/Mftf/Test/AdminDeleteActiveTextTermEntityTest.xml<br>")
 * @TestCaseId("MC-14663")
 * @group checkoutAgreements
 * @group mtf_migrated
 */
class AdminDeleteActiveTextTermEntityTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createdProduct", "hook", "SimpleTwo", [], []); // stepKey: createdProduct
		$I->comment("Entering Action Group [openNewTerm] AdminTermsConditionsOpenNewTermPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/checkout/agreement/new"); // stepKey: amOnNewTermPageOpenNewTerm
		$I->waitForPageLoad(30); // stepKey: waitForAdminNewTermPageLoadOpenNewTerm
		$I->comment("Exiting Action Group [openNewTerm] AdminTermsConditionsOpenNewTermPageActionGroup");
		$I->comment("Entering Action Group [createTerm] AdminTermsConditionsFillTermEditFormActionGroup");
		$I->fillField("#name", "name" . msq("activeTextTerm")); // stepKey: fillFieldConditionNameCreateTerm
		$I->selectOption("#is_active", "Enabled"); // stepKey: selectOptionIsActiveCreateTerm
		$I->selectOption("#is_html", "Text"); // stepKey: selectOptionIsHtmlCreateTerm
		$I->selectOption("#mode", "Manually"); // stepKey: selectOptionModeCreateTerm
		$I->selectOption("#stores", "Default Store View"); // stepKey: selectOptionStoreViewCreateTerm
		$I->fillField("#checkbox_text", "test_checkbox" . msq("activeTextTerm")); // stepKey: fillFieldCheckboxTextCreateTerm
		$I->fillField("#content", "TestMessage" . msq("activeTextTerm")); // stepKey: fillFieldContentCreateTerm
		$I->comment("Exiting Action Group [createTerm] AdminTermsConditionsFillTermEditFormActionGroup");
		$I->comment("Entering Action Group [saveNewTerm] AdminTermsConditionsSaveTermActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveTermSaveNewTerm
		$I->see("You saved the condition.", ".message-success"); // stepKey: seeSuccessMessageSaveNewTerm
		$I->comment("Exiting Action Group [saveNewTerm] AdminTermsConditionsSaveTermActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setDisableTermsOnCheckout = $I->magentoCLI("config:set checkout/options/enable_agreements 0", 60); // stepKey: setDisableTermsOnCheckout
		$I->comment($setDisableTermsOnCheckout);
		$I->deleteEntity("createdProduct", "hook"); // stepKey: deletedProduct
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
	public function AdminDeleteActiveTextTermEntityTest(AcceptanceTester $I)
	{
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
		$I->comment("Entering Action Group [assertTermAbsentInGrid] AdminAssertTermAbsentInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/checkout/agreement/"); // stepKey: onTermGridPageAssertTermAbsentInGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertTermAbsentInGrid
		$I->fillField("#agreementGrid_filter_name", "name" . msq("activeTextTerm")); // stepKey: fillTermNameFilterAssertTermAbsentInGrid
		$I->click("//div[contains(@class,'admin__data-grid-header')]//div[contains(@class,'admin__filter-actions')]/button[1]"); // stepKey: clickSearchButtonAssertTermAbsentInGrid
		$I->dontSee("name" . msq("activeTextTerm"), ".data-grid>tbody>tr>td.col-name"); // stepKey: assertTermAbsentInGridAssertTermAbsentInGrid
		$I->comment("Exiting Action Group [assertTermAbsentInGrid] AdminAssertTermAbsentInGridActionGroup");
		$I->comment("Entering Action Group [openProductPage] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createdProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageOpenProductPage
		$I->click("button.action.tocart.primary"); // stepKey: addToCartOpenProductPage
		$I->waitForPageLoad(30); // stepKey: addToCartOpenProductPageWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingOpenProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedOpenProductPage
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageOpenProductPage
		$I->see("You added " . $I->retrieveEntityField('createdProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [processCheckoutToThePaymentMethodsPage] StorefrontProcessCheckoutToPaymentActionGroup");
		$I->comment("Go to Checkout");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityProcessCheckoutToThePaymentMethodsPage
		$I->wait(5); // stepKey: waitMinicartRenderingProcessCheckoutToThePaymentMethodsPage
		$I->click("a.showcart"); // stepKey: clickCartProcessCheckoutToThePaymentMethodsPage
		$I->waitForPageLoad(60); // stepKey: clickCartProcessCheckoutToThePaymentMethodsPageWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutProcessCheckoutToThePaymentMethodsPage
		$I->waitForPageLoad(30); // stepKey: goToCheckoutProcessCheckoutToThePaymentMethodsPageWaitForPageLoad
		$I->comment("Process steps");
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailProcessCheckoutToThePaymentMethodsPage
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameProcessCheckoutToThePaymentMethodsPage
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameProcessCheckoutToThePaymentMethodsPage
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetProcessCheckoutToThePaymentMethodsPage
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityProcessCheckoutToThePaymentMethodsPage
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionProcessCheckoutToThePaymentMethodsPage
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeProcessCheckoutToThePaymentMethodsPage
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneProcessCheckoutToThePaymentMethodsPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForShippingMethodsProcessCheckoutToThePaymentMethodsPage
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodProcessCheckoutToThePaymentMethodsPage
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForTheNextButtonProcessCheckoutToThePaymentMethodsPage
		$I->waitForPageLoad(30); // stepKey: waitForTheNextButtonProcessCheckoutToThePaymentMethodsPageWaitForPageLoad
		$I->waitForElementNotVisible(".loading-mask", 300); // stepKey: waitForProcessShippingMethodProcessCheckoutToThePaymentMethodsPage
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextProcessCheckoutToThePaymentMethodsPage
		$I->waitForPageLoad(30); // stepKey: clickNextProcessCheckoutToThePaymentMethodsPageWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedProcessCheckoutToThePaymentMethodsPage
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlProcessCheckoutToThePaymentMethodsPage
		$I->comment("Exiting Action Group [processCheckoutToThePaymentMethodsPage] StorefrontProcessCheckoutToPaymentActionGroup");
		$I->comment("Entering Action Group [assertTermAbsentInCheckout] AssertStorefrontTermAbsentInCheckoutActionGroup");
		$I->comment("Check if agreement is absent on checkout");
		$I->dontSee("test_checkbox" . msq("activeTextTerm"), "div.checkout-agreements-block > div > div > div > label > button > span"); // stepKey: seeTermInCheckoutAssertTermAbsentInCheckout
		$I->comment("Checkout select Check/Money Order payment");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForPaymentPageRenderingAssertTermAbsentInCheckout
		$I->waitForPageLoad(30); // stepKey: waitForPaymentRenderingAssertTermAbsentInCheckout
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodAssertTermAbsentInCheckout
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionAssertTermAbsentInCheckout
		$I->comment("Click Place Order button");
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderAssertTermAbsentInCheckout
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderAssertTermAbsentInCheckoutWaitForPageLoad
		$I->comment("See success messages");
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: seeSuccessTitleAssertTermAbsentInCheckout
		$I->see("Your order # is: ", ".checkout-success > p:nth-child(1)"); // stepKey: seeOrderNumberAssertTermAbsentInCheckout
		$I->comment("Exiting Action Group [assertTermAbsentInCheckout] AssertStorefrontTermAbsentInCheckoutActionGroup");
	}
}
