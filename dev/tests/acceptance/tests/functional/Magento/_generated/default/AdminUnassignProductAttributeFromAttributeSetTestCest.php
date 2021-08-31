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
 * @Title("MC-194: Admin should be able to unassign attributes from an attribute set")
 * @Description("Admin should be able to unassign attributes from an attribute set<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUnassignProductAttributeFromAttributeSetTest.xml<br>")
 * @TestCaseId("MC-194")
 * @group Catalog
 */
class AdminUnassignProductAttributeFromAttributeSetTestCest
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
		$I->createEntity("attribute", "hook", "productDropDownAttribute", [], []); // stepKey: attribute
		$I->createEntity("option1", "hook", "productAttributeOption1", ["attribute"], []); // stepKey: option1
		$I->createEntity("option2", "hook", "productAttributeOption2", ["attribute"], []); // stepKey: option2
		$I->createEntity("addToDefaultSet", "hook", "AddToDefaultSet", ["attribute"], []); // stepKey: addToDefaultSet
		$I->createEntity("product", "hook", "ApiProductWithDescription", [], []); // stepKey: product
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
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("attribute", "hook"); // stepKey: deleteAttribute
		$runCron = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCron
		$I->comment($runCron);
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Add/Update attribute set"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUnassignProductAttributeFromAttributeSetTest(AcceptanceTester $I)
	{
		$I->comment("Assert attribute presence in storefront product additional information");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onProductPage1
		$I->waitForPageLoad(30); // stepKey: wait1
		$I->comment("Entering Action Group [checkAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->click("#tab-label-additional-title"); // stepKey: clickTabCheckAttributeInMoreInformationTab
		$I->waitForPageLoad(30); // stepKey: clickTabCheckAttributeInMoreInformationTabWaitForPageLoad
		$I->see($I->retrieveEntityField('attribute', 'attribute[frontend_labels][0][label]', 'test'), "#additional"); // stepKey: seeAttributeLabelCheckAttributeInMoreInformationTab
		$I->see($I->retrieveEntityField('option2', 'option[store_labels][0][label]', 'test'), "#additional"); // stepKey: seeAttributeValueCheckAttributeInMoreInformationTab
		$I->comment("Exiting Action Group [checkAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->comment("Go to default attribute set edit page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/edit/id/4/"); // stepKey: onAttributeSetEdit
		$I->comment("Assert created attribute in a group");
		$I->see($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttributeInGroup
		$I->comment("Unassign attribute from group");
		$I->comment("Entering Action Group [UnassignAttributeFromGroup] UnassignAttributeFromGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupUnassignAttributeFromGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1UnassignAttributeFromGroup
		$I->dragAndDrop("//*[@id='tree-div1']//span[text()='" . $I->retrieveEntityField('attribute', 'attribute_code', 'test') . "']", "//*[@id='tree-div2']//li[1]//a/span"); // stepKey: dragAndDropToUnassignedUnassignAttributeFromGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2UnassignAttributeFromGroup
		$I->see($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div2"); // stepKey: seeAttributeInUnassignedUnassignAttributeFromGroup
		$I->comment("Exiting Action Group [UnassignAttributeFromGroup] UnassignAttributeFromGroupActionGroup");
		$I->comment("Assert attribute in unassigned section");
		$I->see($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div2"); // stepKey: seeAttributeInUnassigned
		$I->comment("Save attribute set");
		$I->comment("Entering Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->comment("Clear cache");
		$I->comment("Entering Action Group [clearPageCacheActionGroup] ClearPageCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementPageClearPageCacheActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearPageCacheActionGroup
		$I->click("//*[@id='cache_grid_massaction-select']//option[contains(., 'Action')]"); // stepKey: actionSelectionClearPageCacheActionGroup
		$I->waitForPageLoad(30); // stepKey: actionSelectionClearPageCacheActionGroupWaitForPageLoad
		$I->click("//*[@id='cache_grid_massaction-select']//option[@value='refresh']"); // stepKey: selectRefreshOptionClearPageCacheActionGroup
		$I->waitForPageLoad(30); // stepKey: selectRefreshOptionClearPageCacheActionGroupWaitForPageLoad
		$I->click("//td[contains(., 'Page Cache')]/..//input[@type='checkbox']"); // stepKey: selectPageCacheRowCheckboxClearPageCacheActionGroup
		$I->click("//button[@title='Submit']"); // stepKey: clickSubmitClearPageCacheActionGroup
		$I->waitForPageLoad(30); // stepKey: clickSubmitClearPageCacheActionGroupWaitForPageLoad
		$I->comment("Exiting Action Group [clearPageCacheActionGroup] ClearPageCacheActionGroup");
		$I->comment("Go to create new product page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: navigateToNewProduct
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->comment("Assert attribute not present in product creation");
		$I->dontSeeElement("//*[@class='admin__field']//span[text()='" . $I->retrieveEntityField('attribute', 'attribute[frontend_labels][0][label]', 'test') . "']"); // stepKey: seeLabel
		$I->comment("Assert removed attribute not presence in storefront product additional information");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onProductPage2
		$I->waitForPageLoad(30); // stepKey: wait3
		$I->dontSeeElement("#tab-label-additional-title"); // stepKey: dontSeeProductAttribute
		$I->waitForPageLoad(30); // stepKey: dontSeeProductAttributeWaitForPageLoad
		$I->dontSee($I->retrieveEntityField('attribute', 'attribute[frontend_labels][0][label]', 'test'), "#additional"); // stepKey: dontSeeAttributeLabel
	}
}
