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
 * @Title("MAGETWO-91101: Category nesting level must be the same as were created in categories.")
 * @Description("Category nesting level must be the same as were created in categories.<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/PriceRuleCategoryNestingTest.xml<br>")
 * @TestCaseId("MAGETWO-91101")
 * @group SalesRule
 */
class PriceRuleCategoryNestingTestCest
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
		$I->createEntity("subcategory1", "hook", "_defaultCategory", [], []); // stepKey: subcategory1
		$I->createEntity("subcategory2", "hook", "SubCategoryWithParent", ["subcategory1"], []); // stepKey: subcategory2
		$I->createEntity("subcategory3", "hook", "SubCategoryWithParent", ["subcategory2"], []); // stepKey: subcategory3
		$I->createEntity("subcategory4", "hook", "SubCategoryWithParent", ["subcategory3"], []); // stepKey: subcategory4
		$I->createEntity("subcategory5", "hook", "SubCategoryWithParent", ["subcategory4"], []); // stepKey: subcategory5
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("subcategory1", "hook"); // stepKey: deleteCategory1
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"SalesRule"})
	 * @Stories({"Create categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function PriceRuleCategoryNestingTest(AcceptanceTester $I)
	{
		$I->comment("Login as admin and open page for creation new Price Rule");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/new/"); // stepKey: openCatalogPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitCatalogPriceRulePageLoad
		$I->comment("Open Conditions section and select Categories condition");
		$I->click("//div[@data-index='conditions']//span[contains(.,'Conditions')][1]"); // stepKey: openConditionsSection
		$I->scrollTo("//div[@data-index='conditions']//span[contains(.,'Conditions')][1]"); // stepKey: scrollToConditionsTab
		$I->click("span.rule-param.rule-param-new-child"); // stepKey: createNewRule
		$I->selectOption("select[data-form-part='sales_rule_form'][data-ui-id='newchild-0-select-rule-conditions-1-new-child']", "Magento\SalesRule\Model\Rule\Condition\Product\Found"); // stepKey: selectProductAttributes
		$I->waitForAjaxLoad(30); // stepKey: ajaxLoad1
		$I->waitForElement("#conditions__1--1__children>li>span>a", 30); // stepKey: wait1
		$I->scrollTo("#conditions__1--1__children>li>span>a"); // stepKey: scrollToAddProductAttributeButton
		$I->click("#conditions__1--1__children>li>span>a"); // stepKey: clickToshowAttributes
		$I->selectOption("#conditions__1--1__new_child", "Magento\SalesRule\Model\Rule\Condition\Product|category_ids"); // stepKey: selectCategoryAttribute
		$I->waitForAjaxLoad(30); // stepKey: ajaxLoad2
		$I->comment("Select categories chooser");
		$I->waitForElement("#conditions__1--1__children>li>span.rule-param:nth-of-type(2)>a", 30); // stepKey: wait2
		$I->click("#conditions__1--1__children>li>span.rule-param:nth-of-type(2)>a"); // stepKey: changeCategories
		$I->click("#conditions__1--1__children>li>span.rule-param:nth-of-type(2)>span>label>a"); // stepKey: showCategoriesChooser
		$I->waitForAjaxLoad(30); // stepKey: ajaxLoad3
		$I->comment("Click on categories to check that the deepest subcategory is clickable");
		$I->waitForElement(".x-tree-root-ct.x-tree-lines", 30); // stepKey: wait3
		$I->click(".x-tree-root-ct.x-tree-lines > div > li > ul > li:last-child div img.x-tree-elbow-end-plus"); // stepKey: openLatestTreeNode1
		$I->click(".x-tree-root-ct.x-tree-lines > div > li > ul > li:last-child div img.x-tree-elbow-end-plus"); // stepKey: openLatestTreeNode2
		$I->click(".x-tree-root-ct.x-tree-lines > div > li > ul > li:last-child div img.x-tree-elbow-end-plus"); // stepKey: openLatestTreeNode3
		$I->waitForAjaxLoad(30); // stepKey: ajaxLoad4
		$I->waitForElement(".x-tree-root-ct.x-tree-lines > div > li > ul > li > ul > li > ul > li > ul > li > div img.x-tree-elbow-end-plus", 30); // stepKey: wait4
		$I->click(".x-tree-root-ct.x-tree-lines > div > li > ul > li > ul > li > ul > li > ul > li > div img.x-tree-elbow-end-plus"); // stepKey: openLatestTreeNode4
	}
}
