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
 * @Title("MC-5472: No validation errors when trying to duplicate product twice")
 * @Description("No validation errors when trying to duplicate product twice<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateProductDuplicateUrlkeyTest/AdminCreateProductDuplicateProductTest.xml<br>")
 * @TestCaseId("MC-5472")
 * @group product
 */
class AdminCreateProductDuplicateProductTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete all products by filtering grid and using mass delete action");
		$I->comment("Entering Action Group [deleteAllDuplicateProducts] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteAllDuplicateProducts
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteAllDuplicateProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteAllDuplicateProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteAllDuplicateProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterDeleteAllDuplicateProducts
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createSimpleProduct', 'name', 'hook')); // stepKey: fillProductNameFilterDeleteAllDuplicateProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteAllDuplicateProductsWaitForPageLoad
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteAllDuplicateProducts
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteAllDuplicateProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllDuplicateProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllDuplicateProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteAllDuplicateProducts
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteAllDuplicateProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteAllDuplicateProductsWaitForPageLoad
		$I->comment("Exiting Action Group [deleteAllDuplicateProducts] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deletePreReqCatalog
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
	 * @Stories({"Validation Errors"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateProductDuplicateProductTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [searchForSimpleProduct1] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct1
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct1
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct1
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct1WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct1
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct1WaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct1] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct1
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct1
		$I->comment("Exiting Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->comment("Save and duplicated the product once");
		$I->comment("Entering Action Group [saveAndDuplicateProductForm1] AdminFormSaveAndDuplicateActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveAndDuplicateProductForm1
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveAndDuplicateProductForm1WaitForPageLoad
		$I->click("span[id='save_and_duplicate']"); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductForm1
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductForm1WaitForPageLoad
		$I->see("You saved the product.", ".message.message-success.success"); // stepKey: assertSaveSuccessSaveAndDuplicateProductForm1
		$I->see("You duplicated the product.", ".message.message-success.success"); // stepKey: assertDuplicateSuccessSaveAndDuplicateProductForm1
		$I->comment("Exiting Action Group [saveAndDuplicateProductForm1] AdminFormSaveAndDuplicateActionGroup");
		$I->comment("Entering Action Group [searchForSimpleProduct2] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct2
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct2
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct2
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct2
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct2WaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct2
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct2WaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct2] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct2
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct2
		$I->comment("Exiting Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->comment("Save and duplicated the product second time");
		$I->comment("Entering Action Group [saveAndDuplicateProductForm2] AdminFormSaveAndDuplicateActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveAndDuplicateProductForm2
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveAndDuplicateProductForm2WaitForPageLoad
		$I->click("span[id='save_and_duplicate']"); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductForm2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductForm2WaitForPageLoad
		$I->see("You saved the product.", ".message.message-success.success"); // stepKey: assertSaveSuccessSaveAndDuplicateProductForm2
		$I->see("You duplicated the product.", ".message.message-success.success"); // stepKey: assertDuplicateSuccessSaveAndDuplicateProductForm2
		$I->comment("Exiting Action Group [saveAndDuplicateProductForm2] AdminFormSaveAndDuplicateActionGroup");
	}
}
