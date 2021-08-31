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
 * @Title("MC-10889: Delete Attribute Set")
 * @Description("Admin should be able to delete an attribute set<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeleteAttributeSetTest.xml<br>")
 * @TestCaseId("MC-10889")
 * @group mtf_migrated
 */
class AdminDeleteAttributeSetTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createAttributeSet
		$I->createEntity("SimpleProductWithCustomAttributeSet", "hook", "SimpleProductWithCustomAttributeSet", ["createCategory", "createAttributeSet"], []); // stepKey: SimpleProductWithCustomAttributeSet
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Attribute sets"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteAttributeSetTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetsPage
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterByAttributeName
		$I->comment("Filter the grid to find created below attribute set");
		$I->click("#container button[title='Search']"); // stepKey: clickSearch
		$I->waitForPageLoad(30); // stepKey: clickSearchWaitForPageLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRow
		$I->comment("Delete attribute set and confirm the modal");
		$I->click("button[title='Delete']"); // stepKey: clickDelete
		$I->waitForPageLoad(30); // stepKey: clickDeleteWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDelete
		$I->waitForPageLoad(30); // stepKey: confirmDeleteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinish
		$I->see("The attribute set has been removed.", ".message-success"); // stepKey: deleteMessage
		$I->comment("Assert the attribute set is not in the grid");
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterByAttributeName2
		$I->click("#container button[title='Search']"); // stepKey: clickSearch2
		$I->waitForPageLoad(30); // stepKey: clickSearch2WaitForPageLoad
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessage
		$I->comment("Search for the product by sku and name on the product page");
		$I->comment("Entering Action Group [goToAdminProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToAdminProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToAdminProductIndex
		$I->comment("Exiting Action Group [goToAdminProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filerProductsBySkuAndName] FilterProductGridBySkuAndNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialFilerProductsBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialFilerProductsBySkuAndNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilerProductsBySkuAndName
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("SimpleProductWithCustomAttributeSet")); // stepKey: fillProductSkuFilterFilerProductsBySkuAndName
		$I->fillField("input.admin__control-text[name='name']", "testProductName" . msq("SimpleProductWithCustomAttributeSet")); // stepKey: fillProductNameFilterFilerProductsBySkuAndName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilerProductsBySkuAndName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilerProductsBySkuAndNameWaitForPageLoad
		$I->comment("Exiting Action Group [filerProductsBySkuAndName] FilterProductGridBySkuAndNameActionGroup");
		$I->comment("Should not see the product");
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessage2
	}
}
