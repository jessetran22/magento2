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
 * @Title("MC-10897: Admin should be able to create a Price product attribute")
 * @Description("Admin should be able to create a Price product attribute<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/CreateProductAttributeEntityTest/CreateProductAttributeEntityPriceTest.xml<br>")
 * @TestCaseId("MC-10897")
 * @group Catalog
 * @group mtf_migrated
 */
class CreateProductAttributeEntityPriceTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToEditPage] NavigateToEditProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridGoToEditPage
		$I->fillField("#attributeGrid_filter_frontend_label", "attribute" . msq("priceProductAttribute")); // stepKey: navigateToAttributeEditPage1GoToEditPage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: navigateToAttributeEditPage2GoToEditPage
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage2GoToEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2GoToEditPage
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: navigateToAttributeEditPage3GoToEditPage
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage3GoToEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3GoToEditPage
		$I->comment("Exiting Action Group [goToEditPage] NavigateToEditProductAttributeActionGroup");
		$I->click("#delete"); // stepKey: clickDelete
		$I->waitForPageLoad(30); // stepKey: clickDeleteWaitForPageLoad
		$I->click(".modal-popup.confirm .action-accept"); // stepKey: clickOk
		$I->waitForPageLoad(30); // stepKey: waitForDeletion
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
	 * @Features({"Catalog"})
	 * @Stories({"Create Product Attributes"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CreateProductAttributeEntityPriceTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to Stores > Attributes > Product.");
		$I->comment("Entering Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageGoToProductAttributes
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToProductAttributes
		$I->comment("Exiting Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->comment("Create new Product Attribute with Price");
		$I->comment("Entering Action Group [createAttribute] CreateProductAttributeActionGroup");
		$I->click("#add"); // stepKey: createNewAttributeCreateAttribute
		$I->fillField("#attribute_label", "attribute" . msq("priceProductAttribute")); // stepKey: fillDefaultLabelCreateAttribute
		$I->selectOption("#frontend_input", "date"); // stepKey: checkInputTypeCreateAttribute
		$I->selectOption("#is_required", "No"); // stepKey: checkRequiredCreateAttribute
		$I->click("#save"); // stepKey: saveAttributeCreateAttribute
		$I->waitForPageLoad(30); // stepKey: saveAttributeCreateAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [createAttribute] CreateProductAttributeActionGroup");
		$I->comment("Navigate to Product Attribute.");
		$I->comment("Entering Action Group [goToEditPage] NavigateToEditProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridGoToEditPage
		$I->fillField("#attributeGrid_filter_frontend_label", "attribute" . msq("priceProductAttribute")); // stepKey: navigateToAttributeEditPage1GoToEditPage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: navigateToAttributeEditPage2GoToEditPage
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage2GoToEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2GoToEditPage
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: navigateToAttributeEditPage3GoToEditPage
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage3GoToEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3GoToEditPage
		$I->comment("Exiting Action Group [goToEditPage] NavigateToEditProductAttributeActionGroup");
		$I->comment("Perform appropriate assertions against priceProductAttribute entity");
		$I->seeInField("#attribute_label", "attribute" . msq("priceProductAttribute")); // stepKey: assertLabel
		$I->seeOptionIsSelected("#frontend_input", "date"); // stepKey: assertInputType
		$I->seeOptionIsSelected("#is_required", "No"); // stepKey: assertRequired
		$I->seeInField("#attribute_code", "attribute" . msq("priceProductAttribute")); // stepKey: assertAttrCode
		$I->comment("Go to New Product page, add Attribute and check values");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: goToCreateSimpleProductPage
		$I->comment("Entering Action Group [addAttributeToProduct] AddProductAttributeInProductModalActionGroup");
		$I->click("#addAttribute"); // stepKey: addAttributeAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: addAttributeAddAttributeToProductWaitForPageLoad
		$I->conditionalClick(".product_form_product_form_add_attribute_modal .action-clear", ".product_form_product_form_add_attribute_modal .action-clear", true); // stepKey: clearFiltersAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clearFiltersAddAttributeToProductWaitForPageLoad
		$I->click(".product_form_product_form_add_attribute_modal button[data-action='grid-filter-expand']"); // stepKey: clickFiltersAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickFiltersAddAttributeToProductWaitForPageLoad
		$I->fillField(".product_form_product_form_add_attribute_modal input[name='attribute_code']", "attribute" . msq("priceProductAttribute")); // stepKey: fillCodeAddAttributeToProduct
		$I->click(".product_form_product_form_add_attribute_modal .admin__data-grid-filters-footer .action-secondary"); // stepKey: clickApplyAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyAddAttributeToProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAddAttributeToProduct
		$I->checkOption(".product_form_product_form_add_attribute_modal .data-grid-checkbox-cell input"); // stepKey: checkAttributeAddAttributeToProduct
		$I->click(".product_form_product_form_add_attribute_modal .page-main-actions .action-primary"); // stepKey: addSelectedAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: addSelectedAddAttributeToProductWaitForPageLoad
		$I->comment("Exiting Action Group [addAttributeToProduct] AddProductAttributeInProductModalActionGroup");
		$I->click("div[data-index='attributes']"); // stepKey: openAttributes
		$I->waitForPageLoad(30); // stepKey: openAttributesWaitForPageLoad
		$I->waitForElementVisible("div[data-index='attribute" . msq("priceProductAttribute") . "'] .admin__field-control input", 30); // stepKey: waitforLabel
		$I->see("attribute" . msq("priceProductAttribute"), "div[data-index='attribute" . msq("priceProductAttribute") . "'] .admin__field-label span"); // stepKey: checkLabel
	}
}
