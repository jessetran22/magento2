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
 * @Title("MC-288: Admin should be able to update existing attributes of child products of a configurable product")
 * @Description("Admin should be able to update existing attributes of child products of a configurable product<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminConfigurableProductUpdateAttributeTest/AdminConfigurableProductUpdateChildAttributeTest.xml<br>")
 * @TestCaseId("MC-288")
 * @group ConfigurableProduct
 */
class AdminConfigurableProductUpdateChildAttributeTestCest
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
		$I->comment("TODO: This should be converted to an actionGroup once MQE-993 is fixed.");
		$I->comment("Create the category the product will be a part of");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->comment("Create the two attributes the product will have");
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->comment("Add the product to the default set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the two attributes");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create the two children product");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->comment("Create the two configurable product with both children");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("login");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->comment("Delete everything that was created in the before block");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCatagory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Edit a configurable product in admin"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigurableProductUpdateChildAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Find the product that we just created using the product grid");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialWaitForPageLoad
		$I->comment("Entering Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFindCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedProduct
		$I->comment("Exiting Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductFilterLoad
		$I->comment("Entering Action Group [openProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenProduct
		$I->comment("Exiting Action Group [openProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Open the wizard for editing configurations and fill out a new attribute");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickEditConfig
		$I->waitForPageLoad(30); // stepKey: clickEditConfigWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEditConfig
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextWizard
		$I->waitForPageLoad(30); // stepKey: clickNextWizardWaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppears
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: createNewValue
		$I->waitForPageLoad(30); // stepKey: createNewValueWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "simple"); // stepKey: fillNewAttribute
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: confirmNewAttribute
		$I->waitForPageLoad(30); // stepKey: confirmNewAttributeWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextWizard2
		$I->waitForPageLoad(30); // stepKey: clickNextWizard2WaitForPageLoad
		$I->comment("Give the product a price and quantity");
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: click
		$I->waitForPageLoad(30); // stepKey: clickWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "100"); // stepKey: fillProductQuantity
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextWizard3
		$I->waitForPageLoad(30); // stepKey: clickNextWizard3WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickGenerateProducts
		$I->waitForPageLoad(30); // stepKey: clickGenerateProductsWaitForPageLoad
		$I->comment("Save the product");
		$I->waitForPageLoad(30); // stepKey: waitForGeneration
		$I->click("#save-button"); // stepKey: saveProductAttribute
		$I->waitForPageLoad(30); // stepKey: saveProductAttributeWaitForPageLoad
		$I->see("You saved the product.", ".message.message-success.success"); // stepKey: assertSuccess
		$I->comment("Check to make sure the created product has appeared on the configurable product storefront");
		$I->amOnPage("/api-configurable-product" . msq("ApiConfigurableProduct") . "2.html"); // stepKey: goToConfigProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->selectOption("//*[text()='" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']/../../..//select", "simple"); // stepKey: clickFirstAttribute
		$I->waitForPageLoad(30); // stepKey: waitForPageExecution
		$I->see("0.00", "div.price-box.price-final_price"); // stepKey: checkPrice
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageLoad
		$I->comment("Find the simple product that we just created using the product grid and delete it");
		$I->comment("Entering Action Group [findCreatedProduct2] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFindCreatedProduct2
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedProduct2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedProduct2
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct") . "2-simple"); // stepKey: fillProductSkuFilterFindCreatedProduct2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedProduct2WaitForPageLoad
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct") . "2-simple", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridFindCreatedProduct2
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownFindCreatedProduct2
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridFindCreatedProduct2
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownFindCreatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownFindCreatedProduct2WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionFindCreatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionFindCreatedProduct2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalFindCreatedProduct2
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalFindCreatedProduct2WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteFindCreatedProduct2
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteFindCreatedProduct2WaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageFindCreatedProduct2
		$I->comment("Exiting Action Group [findCreatedProduct2] DeleteProductBySkuActionGroup");
	}
}
